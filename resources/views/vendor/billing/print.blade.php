<!DOCTYPE html>
<html>
<head>
<title>Billing ID</title>
<style> 
.div1 {
  width: 300px;
  height: 100px;
  border: 1px solid black;
  box-sizing: border-box;
}

.div2 {
  width: 300px;
  height: 100px;  
  padding: 50px;
  border: 1px solid red;
  box-sizing: border-box;
}
</style>
</head>
<body>

<div class="div1">
    <p style="margin-top:10px;text-align:center;">Billing ID 
        <br>
        <h1 style="text-align:center;"> {{ $billingId }} </h1>
    </p>
</div>
<br>
<script>
    window.print()
</script>
</body>
</html>
