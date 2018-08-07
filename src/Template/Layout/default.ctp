<?php
$controller = strtolower($this->request->params['controller']);
$action = strtolower($this->request->params['action']);
$pass = $this->request->params['pass'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Cache-control" content="no-store; no-cache"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<title><?= $title ?> - TADIEX</title>
<meta name="keywords" content="" />
<meta name="description" content="<?=$meta_description?>" />
<meta name="author" content="TADIEX" />
<meta name="generator" content="Ngô Thắng" />
<meta name="robots" content="index, follow" /> 
<meta name="googlebot" content="index, follow" />
<meta name="bingbot" content="index, follow" />
<meta name="geo.region" content="VN-HN" />
<meta name="geo.position" content="20.97449;105.825924" />
<meta name="ICBM" content="20.97449, 105.825924" />

<link rel="icon" href="<?php echo SITE_URL ?>/img/frontend/logo.png" sizes="32x32" />
<link rel="icon" href="<?php echo SITE_URL ?>/img/frontend/logo.png" sizes="192x192" />
<link rel="apple-touch-icon-precomposed" href="<?php echo SITE_URL ?>/img/frontend/logo.png" /> <!--180x180 px-->
<meta name="msapplication-TileImage" content="<?php echo SITE_URL ?>/img/frontend/logo.png" /> <!--270x270 px-->
<?= $this->Html->meta('icon') ?>
<?= $this->fetch('meta') ?>

<link rel="canonical" href="<?=$canonical?>" />
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="publisher" href="https://plus.google.com/+NgôVănThắngIT"/>
<link rel="alternate" href="<?php echo SITE_URL ?>/" hreflang="vi-vn" />
<link rel="alternate" href="<?php echo SITE_URL ?>/en" hreflang="en-us" />
<?= $this->Html->css('bootstrap.min.css') ?>
<?= $this->Html->css('app.css') ?>

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
    var siteUrl = "<?php echo SITE_URL ?>";
    var is_home = <?php echo ($controller=="pages" and $action=="display" and $pass[0]=="home")?"true":"false"; ?>;
    var is_mobile = false;
    var is_auth = <?php echo ($this->request->session()->read('Auth.User.username'))?"true":"false" ?>;
</script>
</head>
<body>
<noscript id="deferred-styles">
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('bootstrap-datetimepicker.min.css') ?>
    <?= $this->Html->css('owl.carousel.min.css') ?>
    <?= $this->Html->css('jquery.fancybox.min.css') ?>
    <?= $this->Html->css('toastr.min.css') ?>
    <?= $this->Html->css('animate.min.css') ?>
    <?= $this->Html->css('common.css') ?>
    <?= $this->fetch('css') ?>
</noscript>
<div id="ajax_loading" style="display: none;z-index: 9999999" class="ajax-loading-block-window">
    <div class="loading-image"></div>
</div>
<div id="ppo-overlay" style="display: none"></div>

<!--BEGIN: DESKTOP HEADER-->
<header id="desktop-header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="top-header-left">
                        <li>
                            <a href="#">
                                <?= $this->Html->image('frontend/view-list-alt.png', ['alt' => 'Tin tức']) ?>
                                Tin tức
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <?= $this->Html->image('frontend/settings.png', ['alt' => 'Cài đặt']) ?>
                                Cài đặt
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <?= $this->Html->image('frontend/download.png', ['alt' => 'Tải về']) ?>
                                Tải về ứng dụng
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 text-right">
                    <ul class="user-login">
                        <?php if ($this->request->session()->read('Auth.User.username')): ?>
                        <li class="avatar">
                            <a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'editProfile'])?>">
                                <?= $this->Html->image('frontend/avatar.png', ['alt' => 'duongnt9x']) ?>
                                <?= $this->request->session()->read('Auth.User.username') ?>
                            </a>
                        </li>
                        <li class="logout">
                            <a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'logout'])?>"
                               onclick="return confirm('Bạn có chắc chắn muốn Đăng xuất không?')">
                                <span class="fa fa-angle-right"></span>
                                Đăng xuất
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="avatar">
                            <a href="javascript://" data-toggle="modal" data-target="#loginModal">
                                <?= $this->Html->image('frontend/user-default.png', ['alt' => 'User']) ?>
                            </a>
                        </li>
                        <li class="login">
                            <a href="javascript://" data-toggle="modal" data-target="#loginModal">
                                Đăng nhập
                            </a>
                        </li>
                        <li class="signup">
                            <a href="javascript://" data-toggle="modal" data-target="#signupModal">
                                <span class="fa fa-angle-right"></span>
                                Đăng ký
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header">
        <div class="container">
            <div class="pull-left">
                <div class="logo">
                    <a rel="home" title="Trao đổi, mua bán wex" href="<?=SITE_URL?>">
                        <?= $this->Html->image('frontend/logo.png', ['itemprop' => 'logo', 'alt' => 'TADIEX']) ?>
                    </a>
                </div>
            </div>
            <div class="pull-right">
                <ul class="menu">
                    <li class="<?php echo ( (strpos($controller, "pages") !== false) or (strpos($controller, "offers") !== false and $action == "trade") )?"actived":"" ?>"><a href="<?=SITE_URL?>">Mua bán wex</a></li>
                    <li class="<?php echo (strpos($controller, "dashboard") !== false)?"actived":"" ?>"><a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'index'])?>">Bảng điều khiển</a></li>
                    <?php if ($this->request->session()->read('Auth.User.wallet')): ?>
                    <li><a href="#" class="wallet wallet-usd">Ví USD
                            <span class="blance">
                                <?php echo number_format($this->request->session()->read('Auth.User.wallet.usd'), 2);?>
                            </span>
                        </a>
                    </li>
                    <li><a href="#" class="wallet wallet-vnd">Ví VNĐ
                            <span class="blance">
                                <?php echo number_format($this->request->session()->read('Auth.User.wallet.vnd'), 2);?>
                            </span>
                        </a>
                    </li>
                    <?php else: ?>
                    <li><a href="#" class="wallet wallet-usd">Ví USD<span class="blance">0.00</span></a></li>
                    <li><a href="#" class="wallet wallet-vnd">Ví VNĐ<span class="blance">0.00</span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--END: DESKTOP HEADER-->

<!--MOBILE HEADER-->
<div id="st-container" class="st-container">
    <div class="mobile-header clearfix mobile-unclicked" style="transform: translate(0px, 0px);">
        <div id="st-trigger-effects">
            <button data-effect="st-effect-4" class="left-menu">
                <div class="menu-icon">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <span><i class="fa fa-bars" aria-hidden="true"></i></span>
            </button>
        </div>
        <div class="title">
            <a rel="home" title="TADIEX" href="<?= SITE_URL ?>">
                <?= $this->Html->image('frontend/logo.png', ['alt' => 'TADIEX']) ?>
            </a>
        </div>
        <div id="st-trigger-effects">
            <div data-effect="st-effect-5" class="right-menu">
                icon
            </div>
        </div>
    </div>

    <nav id="menu-4" class="st-menu st-effect-4">
        <form method="get" action="/search/" id="search_mini_form">
            <div class="form-search">
                <div class="searchcontainer"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <input type="text" maxlength="128" class="input-text" value="" name="s" id="search" />
                </div>
            </div>
        </form>

        <ul class="nav">
            <li><a href="<?=SITE_URL?>">Mua Bán WEX</a></li>
            <li><a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'index'])?>">Bảng điều khiển</a></li>
        </ul>
    </nav>
</div>
<!--/MOBILE HEADER-->

<!--BEGIN: FLASH MESSAGE-->
<div class="container"><?= $this->Flash->render() ?></div>
<!--END: FLASH MESSAGE-->

<!--BEGIN: MAIN CONTENT-->
<div class="main-content">
    <?= $this->fetch('content') ?>
</div>
<!--END: MAIN CONTENT-->

<!--BEGIN: FOOTER-->
<section id="footer">
    <div class="footer1">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="widget-title">Thông tin liên hệ</h3>
                    <div class="address"><span>Địa chỉ:</span> 249/115 Hà Huy Tập</div>
                    <div class="phone"><span>Điện Thoại:</span> 91 999 999 999</div>
                    <div class="email"><span>Email:</span> tadiex@gmail.com</div>
                    <div class="social">
                        <?= $this->Html->image('frontend/facebook.png', ['alt' => 'Facebook', 'class' => 'facebook']) ?>
                        <?= $this->Html->image('frontend/twitter.png', ['alt' => 'Twitter', 'class' => 'twitter']) ?>
                        <?= $this->Html->image('frontend/google.png', ['alt' => 'Google', 'class' => 'google']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <h3 class="widget-title">Giới thiệu</h3>
                    <ul class="aboutus">
                        <li><a href="#">Về Chúng Tôi</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Về Chúng Tôi</a></li>
                        <li><a href="#">Giao dịch đảm bảo</a></li>
                        <li><a href="#">Truyền thông</a></li>
                        <li><a href="#">Đội ngũ</a></li>
                        <li><a href="#">Chính sách và phát triển</a></li>
                        <li><a href="#">Become our partner</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3 class="widget-title">Tin tức</h3>
                    <div class="mb30">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="thumbnail-news">
                                    <?= $this->Html->image('frontend/thumbnail.png', ['alt' => 'Thumbnail']) ?>
                                </div>
                            </div>
                            <div class="col-sm-9 pdl0">
                                <div class="title-news">
                                    How To Boost Your Traffic Of Your Blog
                                </div>
                                <div class="exceprt-news">
                                    I want to talk about to things that are quite important to me. There are love and one my personal inadequacies. The thing is that I’m quite fond of love, I think that it’s a pretty all right deal ...
                                </div>
                                <div class="published-date">
                                    27/02/2018
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="thumbnail-news">
                                    <?= $this->Html->image('frontend/thumbnail.png', ['alt' => 'Thumbnail']) ?>
                                </div>
                            </div>
                            <div class="col-sm-9 pdl0">
                                <div class="title-news">
                                    How To Boost Your Traffic Of Your Blog
                                </div>
                                <div class="exceprt-news">
                                    I want to talk about to things that are quite important to me. There are love and one my personal inadequacies. The thing is that I’m quite fond of love, I think that it’s a pretty all right deal ...
                                </div>
                                <div class="published-date">
                                    27/02/2018
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer2">
        Copyright &copy; TADIEX. All rights reserved.
    </div>
</section>
<!--END: FOOTER-->

<!--POPUP LOGIN-->
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ĐĂNG NHẬP</h4>
            </div>
            <div class="modal-body">
                <form id="login_form" method="post" action="<?=$this->Url->build(['controller' => 'Users', 'action' => 'login'])?>">
                    <div id="login_result" style="margin-bottom: 5px;color: red;"></div>
                    <div class="form-group">
                        <label for="username"><?php echo __('Tên đăng nhập'); ?></label>
                        <input type="text" class="form-control input-lg" value="" name="username" id="username" required />
                    </div>
                    <div class="form-group">
                        <label for="password"><?php echo __('Mật khẩu'); ?></label>
                        <input type="password" class="form-control input-lg" value="" name="password" id="password" required />
                    </div>
                    <div class="submit_section">
                        <button type="submit" id="btnLogin" class="btn btn-lg btn-success btn-block"><?php echo __('Đăng nhập'); ?></button>
                        <input type="hidden" name="redirect_url" value="<?php // echo $_SERVER['HTTP_REFERER'];  ?>" />
                    </div>
                </form>
            </div>
            <div class="modal-footer t_center">
                <div data-dismiss="modal" data-toggle="modal" data-target="#signupModal">
                    Chưa có tài khoản? <span style="color:#0d95e8;cursor:pointer">Đăng ký</span>
                </div>
            </div>
        </div>

    </div>
</div>

<!--POPUP SIGNUP-->
<div id="signupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ĐĂNG KÝ</h4>
            </div>
            <div class="modal-body">
                <form id="signup_form" method="post" action="<?=$this->Url->build(['controller' => 'Users', 'action' => 'signup'])?>">
                    <div id="signup_result" style="margin-bottom: 5px;color: red;"></div>
                    <div class="form-group">
                        <label for="signup_username"><?php echo __('Tên đăng nhập'); ?></label>
                        <input type="text" class="form-control" value="" name="username" id="signup_username" required />
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="signup_password"><?php echo __('Mật khẩu'); ?></label>
                                <input type="password" class="form-control" value="" name="password" id="signup_password" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password"><?php echo __('Gõ lại Mật khẩu'); ?></label>
                                <input type="password" class="form-control" value="" name="confirm_password" id="confirm_password" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email"><?php echo __('Email'); ?></label>
                        <input type="email" class="form-control" value="" name="email" id="email" required />
                    </div>
                    <div class="form-group">
                        <label for="confirm_email"><?php echo __('Gõ lại Email'); ?></label>
                        <input type="email" class="form-control" value="" name="confirm_email" id="confirm_email" required />
                    </div>
                    <div class="form-group">
                        <label class="normal">
                            <input type="checkbox" name="chkAccept" id="chkAccept" />
                            <?php echo __('Tôi đã đọc và đồng ý với điều khoản sử dụng tại TADIEX'); ?>
                        </label>
                    </div>
                    <div class="submit_section">
                        <button type="submit" id="btnSignup" class="btn btn-lg btn-success btn-block"><?php echo __('Đăng ký'); ?></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer t_center">
                <div data-dismiss="modal" data-toggle="modal" data-target="#loginModal">
                    Đã có tài khoản? <span style="color:#0d95e8;cursor:pointer">Đăng nhập</span>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Reference Scripts -->
<?php echo $this->Html->script(['jquery.js', 'moment.min.js', 'jquery-ui.min.js'], ['type' => 'text/javascript']); ?>
<?php echo $this->Html->script(['bootstrap.min.js', 'bootstrap-datetimepicker.min.js'], ['type' => 'text/javascript']); ?>
<?php echo $this->Html->script(['wow.min.js', 'owl.carousel.min.js', 'fancybox/jquery.fancybox.min.js'], ['type' => 'text/javascript']); ?>
<?php echo $this->Html->script(['jquery-scrolltofixed-min.js', 'toastr.min.js', 'hammer.min.js'], ['type' => 'text/javascript']); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<?= $this->fetch('script') ?>
<?php echo $this->Html->script('app.js', ['type' => 'text/javascript']); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!--Start Load stylesheets-->
<script>
  var loadDeferredStyles = function() {
    var addStylesNode = document.getElementById("deferred-styles");
    var replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement);
    addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = requestAnimationFrame || mozRequestAnimationFrame ||
      webkitRequestAnimationFrame || msRequestAnimationFrame;
  if (raf){ raf(function() { window.setTimeout(loadDeferredStyles, 0); });}
  else{ window.addEventListener('load', loadDeferredStyles);}
</script>
<!--End Load stylesheets-->
</body>
</html>