@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#FAF8F5] pt-32 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-building-columns text-blue-600 text-2xl"></i>
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-navy-800 mb-2">Payment Information</h1>
            <p class="text-gray-500">Complete your booking payment via bank transfer to one of our accounts below.</p>
        </div>

        {{-- How to Pay Steps --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b bg-navy-800 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gold-400/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-circle-info text-gold-400"></i>
                    </div>
                    <h2 class="font-display text-xl font-bold">How to Pay</h2>
                </div>
            </div>
            <div class="p-6">
                <ol class="space-y-5">
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">1</span>
                        <div>
                            <p class="font-semibold text-navy-800">Make a booking</p>
                            <p class="text-sm text-gray-500">Book your room through our website. You will receive a booking code after submitting your reservation.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">2</span>
                        <div>
                            <p class="font-semibold text-navy-800">Transfer the payment</p>
                            <p class="text-sm text-gray-500">Transfer the total amount to one of the bank accounts listed below. Make sure the amount matches exactly.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">3</span>
                        <div>
                            <p class="font-semibold text-navy-800">Confirm via WhatsApp</p>
                            <p class="text-sm text-gray-500">Send your transfer proof to our receptionist via WhatsApp along with your booking code.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">4</span>
                        <div>
                            <p class="font-semibold text-navy-800">Booking confirmed</p>
                            <p class="text-sm text-gray-500">Once the payment is verified, your booking will be confirmed and you will receive a confirmation email.</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>

        {{-- Bank Transfer Accounts --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b bg-blue-50 border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-building-columns text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-display text-xl font-bold text-navy-800">Bank Accounts</h2>
                        <p class="text-sm text-gray-500">Transfer your payment to one of the following bank accounts</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @forelse($bankAccounts as $bank)
                    <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-200 transition {{ $loop->first ? 'ring-2 ring-blue-100 bg-blue-50/50' : '' }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-400 uppercase font-medium">Bank</p>
                                <p class="font-bold text-lg text-navy-800">{{ $bank['name'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400 uppercase font-medium">Account Number</p>
                                <p class="font-mono font-bold text-lg text-navy-800 tracking-wider select-all">{{ $bank['account'] }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 uppercase font-medium">Account Holder</p>
                            <p class="font-semibold text-gray-700">{{ $bank['holder'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-4">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        Bank account information is not available yet. Please contact reception for payment instructions.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Track Booking Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass text-green-600"></i>
                    </div>
                    <h2 class="font-display text-xl font-bold text-navy-800">Already Have a Booking?</h2>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-500 mb-5">
                    If you have already made a booking, you can track its status or proceed to payment by entering your booking code below.
                </p>
                <form action="{{ route('booking.lookup') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <input type="text" name="booking_code" placeholder="Enter your booking code (e.g. ICNBZK4WL)"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold-400 focus:ring-2 focus:ring-gold-400/20 outline-none transition font-mono"
                               required>
                    </div>
                    <button type="submit" class="btn-gold whitespace-nowrap">
                        <i class="fa-solid fa-search"></i> Track Booking
                    </button>
                </form>
            </div>
        </div>

        {{-- Contact Support --}}
        <div class="text-center">
            <p class="text-gray-400 text-sm mb-3">Need help with your payment?</p>
            <div class="flex items-center justify-center gap-3">
                @if($whatsapp)
                    <a href="https://api.whatsapp.com/send?phone={{ $whatsapp }}&text={{ urlencode('Halo, saya ingin bertanya tentang pembayaran booking di ' . $hotelName) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-all hover:shadow-lg text-sm">
                        <i class="fa-brands fa-whatsapp"></i>
                        WhatsApp
                    </a>
                @endif
                @if($phone)
                    <a href="tel:{{ $phone }}"
                       class="inline-flex items-center gap-2 bg-navy-800 hover:bg-navy-900 text-white font-semibold px-5 py-2.5 rounded-xl transition-all hover:shadow-lg text-sm">
                        <i class="fa-solid fa-phone"></i>
                        {{ $phone }}
                    </a>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
