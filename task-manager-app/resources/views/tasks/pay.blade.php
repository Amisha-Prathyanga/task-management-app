@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Pay for Task: {{ $task->title }}</h1>
    <p class="mb-4">Amount: $10</p>

    <form action="{{ route('tasks.processPayment', $task->id) }}" method="POST" id="payment-form">
        @csrf
        <div class="form-group mb-3">
            <label for="card-element">Credit or Debit Card</label>
            <div id="card-element" class="form-control">
            </div>
            <div id="card-errors" class="text-danger mt-2"></div>
        </div>
        <button type="submit" class="btn btn-primary">Pay $10</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_PUBLIC") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const { token, error } = await stripe.createToken(card);
        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>
@endsection
