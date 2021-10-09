ご予約を受け付けました。
【予約日時】 {{ $reservation_date }}
【予約時間】 {{ $reservation_time. ':00' }}

予約キャンセルをご希望の場合は、下記からお願い致します。
{{ route('dispCancelCodeVerify') }}

※上記画面にて下記をご入力ください。
【id】 {{ $id }}
【キャンセルコード】 {{ $cancel_code }}
