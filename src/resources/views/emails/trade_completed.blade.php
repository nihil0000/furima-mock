<!DOCTYPE html>
<html>
<head>
    <title>取引完了のお知らせ</title>
</head>
<body>
    <h1>取引完了のお知らせ</h1>
    
    <p>{{ $trade->buyer->name }} さんとの取引が完了しました。</p>
    
    <h2>商品情報</h2>
    <p>商品名: {{ $trade->product->product_name }}</p>
    <p>価格: ¥{{ number_format($trade->product->price) }}</p>
    
    <p>ご確認よろしくお願いいたします。</p>
    
    <p>furima事務局</p>
</body>
</html> 
