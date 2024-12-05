<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaypalController;

class CompletedChallengesController extends Controller
{

    protected $paypalController;

    public function __construct(PaypalController $paypalController)
    {
        $this->paypalController = $paypalController;
        $this->middleware('auth');

    }

    public function index()
    {
        $user = Auth::user();
        $completedChallenges = $user->completedChallenges()->with('certificates')->get();

        $challengesWithCertificateStatus = $completedChallenges->map(function ($challenge) use ($user) {
            $hasCertificate = $challenge->certificates->contains('user_id', $user->id);
            return [
                'challenge' => $challenge,
                'hasCertificate' => $hasCertificate,
            ];
        });

        return view('dashboard.completed-challenges', compact('challengesWithCertificateStatus'));
    }

    public function requestCertificate(Challenge $challenge)
    {
        $user = Auth::user();
        if (!$user->completedChallenges->contains($challenge)) {
            return redirect()->back()->with('error', 'You have not completed this challenge.');
        }
        // Store the challenge ID in the session for later use
        session(['certificate_challenge_id' => $challenge->id]);
        // Redirect to the payment process
        return $this->paypalController->processTransaction(10.00); // Assuming the certificate costs $10
    }

    public function successTransaction(Request $request)
    {
        $result = $this->paypalController->successTransaction($request);

        if ($result->getSession()->has('success')) {
            // Payment was successful, create the certificate
            $challengeId = session('certificate_challenge_id');
            $challenge = Challenge::findOrFail($challengeId);

            $certificate = Certificate::create([
                'user_id' => Auth::id(),
                'challenge_id' => $challengeId,
                'issued_at' => now(),
            ]);

            // Clear the session data
            session()->forget('certificate_challenge_id');

            return redirect()->route('completed-challenges.index')
                ->with('success', 'Payment successful. Your certificate has been added to your list.');
        }

        return $result; // This will redirect to homepage with error message if payment failed
    }

    public function cancelTransaction(Request $request)
    {
        // Clear the session data
        session()->forget('certificate_challenge_id');
        return $this->paypalController->cancelTransaction($request);
    }
}
