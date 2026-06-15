<x-mail::message>
# Bedankt voor je bestelling, {{ $order->first_name }}!

We hebben je betaling succesvol ontvangen en zijn direct voor je aan de slag gegaan.
Je ordernummer is **{{ $order->order_number }}**.

## Je Bestelling
<x-mail::table>
| Product       | Aantal         | Prijs  |
| ------------- |:-------------:| --------:|
@foreach($order->items as $item)
| {{ $item->product_name }} {{ $item->variant_name ? '(' . $item->variant_name . ')' : '' }} | {{ $item->quantity }}x | &euro; {{ number_format($item->subtotal, 2, ',', '.') }} |
@endforeach
| **Totaal** | | **&euro; {{ number_format($order->total_price, 2, ',', '.') }}** |
</x-mail::table>

## Verzendadres
**{{ $order->first_name }} {{ $order->last_name }}**<br>
{{ $order->address }}<br>
{{ $order->zipcode }} {{ $order->city }}

---

### Betaalreferentie
Als er onverhoopt iets is misgegaan met je betaling of je hebt vragen voor Stripe, dan is hier je unieke transactie-token:
**Stripe Sessie ID:** `{{ $order->stripe_session_id }}`

<x-mail::button :url="route('shop.index')">
Verder Winkelen
</x-mail::button>

Met vriendelijke groet,<br>
Het team van {{ config('app.name') }}
</x-mail::message>
