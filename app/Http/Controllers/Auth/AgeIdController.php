<?php

namespace App\Http\Controllers\Auth;

use App\AgeID\PayloadEncrypter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgeID\APIWrapper as AgeIdApiWrapper;
use App\AgeID\PayloadHelper;

class AgeIdController extends Controller
{
    /**
     * Process request from modal
     */
    public function modalCallback(Request $request)
    {
        $ageIdApiWrapper = new AgeIdApiWrapper();

        if ($request->has('code')) {
            $ageIdResponse = $ageIdApiWrapper->callWithCode($request->get('code'), $this->getIp() );
        } else
            $ageIdResponse = $ageIdApiWrapper->callWithToken(session()->get('ageId')['token']);

        session()->forget('ageId');
        session()->put('ageId', $ageIdResponse);

        return response()->json($ageIdResponse);
    }

    /**
     * Process request from AgeIdRedirect
     */
    public function redirectCallback(Request $request)
    {
        $ageIdApiWrapper = new AgeIdApiWrapper();

        if ($request->has('code')) {
            $ageIdResponse = $ageIdApiWrapper->callWithCode($request->get('code'), $this->getIp());
        } else
            $ageIdResponse = $ageIdApiWrapper->callWithToken(session()->get('ageId')['token']);

        session()->forget('ageId');
        session()->put('ageId', $ageIdResponse);

        return response()->json($ageIdResponse);
    }

    public function callbackRedirect(Request $request)
    {
        $payloadHelper = new PayloadEncrypter();
        $payloadHelper->useKey(config('ageId.EncryptionKey'));
        $status = '';

        if ($request->has('error') && $request->get('error') == 'unauthorized')
            return redirect()->route('redirect.ageid');

        if ($request->get("payload")) {
            $status = $payloadHelper->decrypt($request->get("payload"))["status"];
            if ($status == "verified") {
                session(['ageId' => ['status' => $status]]);
            } else {
                session()->forget('ageId');
            }
            return redirect()->route("home");
        }

        return view('redir', [
            'ageIdUrl' => \Config::get('ageId.baseURL'),
            'error' => $request->get("error"),
            'status' => $status
        ]);
    }

    public function authenticate(Request $request)
    {
        $isRedirect = \Config::get('ageId.pilot') == 'redirect';

        return $this->isAgeIdRedirect() ? $this->useAgeIdRedirect() : $this->useAgeIdModal();
    }

    private function isAgeIdRedirect()
    {
        return \Config::get('ageId.pilot') == 'redirect';
    }

    private function useAgeIdRedirect()
    {
        $payloadHelper = new PayloadHelper();
        $payloadData = $payloadHelper->generateForRedirectHandshake();

        return view('sfw-redirect', [
            'ageIdUrl' => \Config::get('ageId.baseURL'),
            'ageIdVersion' => \Config::get('ageId.version'),
            'pilot' => \Config::get('ageId.pilot'),
            'clientId' => $payloadHelper->clientId,
            'payload' => $payloadData
        ]);
    }

    private function useAgeIdModal()
    {
        $payloadHelper = new PayloadHelper();
        $payloadData = $payloadHelper->generateForModalHandshake();

        return view('sfw', [
            'ageIdUrl' => \Config::get('ageId.baseURL'),
            'ageIdVersion' => \Config::get('ageId.version'),
            'callbackUrl' => \Config::get('ageId.callbackURL'),
            'pilot' => \Config::get('ageId.pilot'),
            'retryCounter' => \Config::get('ageId.retryCounter'),
            'retryInterval' => \Config::get('ageId.retryInterval'),
            'clientId' => $payloadHelper->clientId,
            'payload' => $payloadData,
            'successUrl' => '/',
            'type' => request()->get('type') ?? 'ageidOnload'
        ]);
    }

    public function redirect()
    {
        $payloadHelper = new PayloadHelper();
        $payloadData = $payloadHelper->generateForRedirectHandshake();
        $url = \Config::get('ageId.baseURL') . '/sso/'.\Config::get('ageId.version').'/handshake?pilot=redirect&client_id=' . $payloadHelper->clientId . '&payload=' . $payloadData;

        return redirect()->to($url);
    }

    /**
     * in case the handshake logic does npt work redirect to this page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noScriptUnauthorized()
    {
        return view('no-script-unauthorized');
    }

    protected function getIp() {
        if( env('NAT_OUTBOUND_IP') ) {
            return env('NAT_OUTBOUND_IP');
        }

        if( request()->server('HTTP_X_FORWARDED_FOR') ) {
            return request()->server('HTTP_X_FORWARDED_FOR');
        } else {
            return request()->ip();
        }
    }
}
