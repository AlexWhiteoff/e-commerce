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
    <? if ($className != 'panel') : ?>
        <footer id="footer" style="height: 470px;">
            <span>
                <div class="go-up-button" id="go-up-button">Go<br>Up</div>
            </span>
            <div class="footer-links">
                <a href="/shop">Shop</a>
                <a href="/about">About</a>
                <a href="/journal">Journal</a>
                <a href="/support">Support</a>
                <a href="/covid">COVID-19 Info</a>
                <a href="http://grovemade/account/index#user-order">Order Status</a>
                <a href="/corpsales">Corporate Sales</a>
            </div>
            <? if (!$userModel->isUserAuthenticated()) : ?>
                <div class="newsletter-signup__media-block">
                    <button class="newsletter-signup__button">Newsletter Signup</button>
                </div>
                <div class="newsletter-signup">
                    <form action="" class="newsletter-signup__form">
                        <h3 class="newsletter-signup__title">Newsletter Signup</h3>
                        <div class="newsletter-signup__text">
                            Sign up to our Newsletter to hear about new product releases, learn about our design process, and everything else going on behind the scenes at Grovemade.
                        </div>
                        <input type="email" name="email" class="newsletter-signup__email" placeholder="Enter your Email">
                        <input type="submit" value="Submit" class="newsletter-signup__submit">
                    </form>
                </div>
            <? endif; ?>
            <div class="copywrite">
                <span>©2020 Grovemade</span>
                <a href="/support/policies/">Terms & Conditions</a>
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="https://department.nyc/">Site by Department</a>
            </div>
        </footer>
    <? else : ?>
        <footer id="footer" style="height: 90px;">
            <div class="copywrite">
                <span>©2020 Grovemade</span>
                <a href="/support/policies/">Terms & Conditions</a>
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="https://department.nyc/">Site by Department</a>
            </div>
        </footer>
    <? endif; ?>

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