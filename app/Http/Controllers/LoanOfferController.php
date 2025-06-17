<?php

namespace App\Http\Controllers;

use App\Models\LoanOffer;
use Illuminate\Http\Request;

class LoanOfferController extends Controller
{
    public function index()
    {
        $loanOffers = LoanOffer::with('lender.user')
        ->orderBy('offer_id', 'desc')
        ->get();
        return view('loan-offers.index', compact('loanOffers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_type' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|min:0|max:99.99',
            'max_amount' => 'required|numeric|min:0',
            'max_duration' => 'required|integer|min:1',
            'lender_id' => 'required|integer|exists:lenders,lender_id',
        ]);
    
       
        LoanOffer::create($validated);
    
        return redirect('/loan-offers')->with('success', 'Offer created successfully!');
    }


    public function update(Request $request, LoanOffer $offer) {
        $validated = $request->validate([
            'loan_type' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|between:0,99.99',
            'max_amount' => 'required|numeric|min:0',
            'max_duration' => 'required|integer|min:1'
        ]);
    
        $offer->update($validated);
        
        return response()->json(['message' => 'Offer updated successfully']);
    }
    
    public function destroy(LoanOffer $offer){
        $offer->delete();
        
        return response()->json(['message' => 'Offer deleted successfully']);
    }
}