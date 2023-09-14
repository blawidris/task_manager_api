@component('mail::message')

# Purchase Confirmation

Thank you for purchasing! here's the details of order;

- Name: {{$purchase->first_name}} {{$purchase->last_name}}
- Address: {{$purchase->address}}
- City: {{$purchase->city}}
- Zipcode: {{$purchase->zipcode}}
- Items: {{$purchase->items}}
@endcomponent
