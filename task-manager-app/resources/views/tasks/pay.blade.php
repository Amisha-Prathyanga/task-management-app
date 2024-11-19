


@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Pay for Task: {{ $task->title }}</h4>
                    <p class="mb-0">Amount: <strong>$10.00</strong></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.processPayment', $task->id) }}" method="POST" id="payment-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control p-2 border border-secondary">
                                <!-- Stripe Card Element -->
                            </div>
                            <div id="card-errors" class="text-danger mt-2"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="fas fa-lock me-2"></i> Pay $10
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">
                        Powered by <span class="text-primary">Stripe</span>. Your payment is secure.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_PUBLIC") }}');
    const elements = stripe.elements();

    // Custom styling for the card element
    const style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };

    // Create the card element and mount it
    const card = elements.create('card', { style: style });
    card.mount('#card-element');

    // Handle real-time validation errors
    card.addEventListener('change', (event) => {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { token, error } = await stripe.createToken(card);
        if (error) {
            // Show error in #card-errors
            document.getElementById('card-errors').textContent = error.message;
        } else {
            // Append the token to the form and submit
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

