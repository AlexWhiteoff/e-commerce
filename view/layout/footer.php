<?php

use models\AccountModel;

$userModel = new AccountModel();
$cart = [];
$pathParts = ['', ''];

if (array_key_exists('path', $_GET)) {
    $path = $_GET['path'];
    $pathParts = explode('/', $path);
}

empty($pathParts[0]) ? $className = 'Home' : $className = $pathParts[0];
empty($pathParts[1]) ? $class = '' : $class = $pathParts[1];

if ($className != 'account' && $className != 'checkout' && $class != 'add' && $class != 'edit') :
?>
    <footer id="footer">
        <span>
            <div class="go-up-button" id="go-up-button">Go<br>Up</div>
        </span>
        <div class="footer-links">
            <div class="footer-links__nav">
                <a href="/shop">Shop</a>
                <a href="/about">About</a>
                <a href="/support">Support</a>
                <a href="/account/index#user-order">Order Status</a>
                <a href="/corpsales">Corporate Sales</a>
            </div>
            <div class="footer-links__copywrite">
                <span>©2020 Woodmade</span>
                <a href="/support/policies/">Terms & Conditions</a>
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="https://github.com/AlexWhiteoff">Site by Alex White</a>
            </div>
        </div>
    </footer>

    <script src="/view/sourse/JavaScript/footerScript.js"></script>
<? endif; ?>

<script src="/view/sourse/JavaScript/<?= $className; ?>Script.js" async type="module"></script>

<!-- Adding scripts for header where it needs -->
<script>
    if (document.body.contains(document.querySelector("header"))) {
        let script = document.createElement('script');
        script.src = '/view/sourse/JavaScript/headerScript.js';
        document.body.append(script);
    }
</script>
</body>

</html>