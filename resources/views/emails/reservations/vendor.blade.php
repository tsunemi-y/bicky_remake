ご予約を受け付けました。

名前　　： {{ !empty($name) ? $name : '' }}
年齢　　： {{ !empty($age) ? $age : '' }}
性別　　： {{ !empty($gender) ? $gender : '' }}
診断名　： {{ !empty($diagnosis) ? $diagnosis : '' }}
住所　　： {{ !empty($address) ? $address : '' }}
紹介先　： {{ !empty($Introduction) ? $Introduction : '' }}
メール　： {{ !empty($email) ? $email : '' }}
予約日時： {{ !empty($reservation_date) ? $reservation_date : '' }}
予約時間： {{ !empty($reservation_time) ? $reservation_time : ''  }}
その他　： 
{{ !empty($note) ? $note : '' }}

