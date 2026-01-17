<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DailyQuoteController extends Controller
{
    public function index()
    {
        $quotes = DailyQuote::orderBy('quote_date', 'desc')->paginate(15);
        return view('admin.daily-quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('admin.daily-quotes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quote_1' => 'required|string|max:255',
            'quote_2' => 'required|string|max:255',
            'quote_3' => 'required|string|max:255',
            'quote_date' => 'required|date|unique:daily_quotes,quote_date',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DailyQuote::create([
            'quote_1' => $request->quote_1,
            'quote_2' => $request->quote_2,
            'quote_3' => $request->quote_3,
            'quote_date' => $request->quote_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.daily-quotes.index')
            ->with('success', 'Phrase du jour créée avec succès.');
    }

    public function edit($id)
    {
        $quote = DailyQuote::findOrFail($id);
        return view('admin.daily-quotes.edit', compact('quote'));
    }

    public function update(Request $request, $id)
    {
        $quote = DailyQuote::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'quote_1' => 'required|string|max:255',
            'quote_2' => 'required|string|max:255',
            'quote_3' => 'required|string|max:255',
            'quote_date' => 'required|date|unique:daily_quotes,quote_date,' . $id,
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $quote->update([
            'quote_1' => $request->quote_1,
            'quote_2' => $request->quote_2,
            'quote_3' => $request->quote_3,
            'quote_date' => $request->quote_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.daily-quotes.index')
            ->with('success', 'Phrase du jour mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $quote = DailyQuote::findOrFail($id);
        $quote->delete();

        return redirect()->route('admin.daily-quotes.index')
            ->with('success', 'Phrase du jour supprimée avec succès.');
    }
}

