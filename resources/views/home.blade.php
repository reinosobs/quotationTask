<!DOCTYPE html>
<html>
<head>
    <title>Quotation Calculator</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Include CSRF token -->
    <form id="apiForm" action="{{ route('quotation') }}" method="post">
        @csrf
        <label for="ages">Ages (comma-separated):</label>
        <input type="text" id="ages" name="ages" required>
        
        <label for="currency">Currency:</label>
        <select id="currency" name="currency" required>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="USD">USD</option>
        </select>
        <div class="container">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date" >End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>

        

        <button type="submit">Calculate</button>

        @if($displayData !== null)
        <div class="result-container">
                <p>Total Price of Policy: <strong> {{ $displayData->total }} </strong></p>
                <p>Currency: <strong> {{ $displayData->currency_id }} </strong></p>
                <p>Quotation ID: <strong> {{ $displayData->quotation_id }} </strong></p>
        </div>
        @endif   
        @if($displayData == null)
        <div class="result-container">
                <p>Total Price of Policy: </p>
                <p>Currency: </p>
                <p>Quotation ID: </p>   
        </div>
        @endif  
    </form>

</body>
</html>
