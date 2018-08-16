<?php
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

$controller = strtolower($this->request->params['controller']);
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title><?= $title ?> - AdScript Administrator</title>
    <meta name="robots" content="noindex, nofollow" /> 
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="bingbot" content="noindex, nofollow" />
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('bootstrap-datetimepicker.min.css') ?>
    <?= $this->Html->css('colorbox/colorbox.css') ?>
    <?= $this->Html->css('select2.min.css') ?>
    <?= $this->Html->css('select2-bootstrap.min.css') ?>
    <?= $this->Html->css('admin.css') ?>
    <?= $this->Html->css('common.css') ?>

    <script>
        var siteUrl = "<?php echo SITE_URL ?>";
        var adminUrl = "<?php echo ADMIN_URL ?>";
        var loginUrl = "<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>";
        var elfinderUrl = "<?= $this->Url->build(['prefix' => false, 'controller' => 'Elfinder', 'action' => 'index']) ?>/";
    </script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo pull-left">
                <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Admins', 'action' => 'display', 'index']) ?>">
                    <?= $this->Html->image('backend/logo.png', ['alt' => 'Logo']) ?>
                </a>
            </div>
            <div class="account pull-right">
                <div class="username">
                    <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'profile']) ?>">
                        <span>01683589280</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                </div>
                <ul>
                    <li>
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'profile']) ?>">
                            <i class="fa fa-unlock-alt"></i> <?= __('Tài Khoản') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'logout']) ?>" 
                           onclick="return confirm('<?= __('Bạn có chắc chắn muốn đăng xuất không?') ?>');">
                            <i class="fa fa-external-link"></i> <?= __('Đăng Xuất') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!--BEGIN: NAVIGATION-->
    <div class="menu-header">
        <div class="container">
            <div class="menu-left pull-left">
                <ul>
                    <li class="<?php echo (strpos($controller, "admin") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Admins', 'action' => 'display', 'index']) ?>">
                            <i class="fa fa-eye"></i> <?= __('Tổng quan') ?>
                        </a>
                    </li>
                    <li class="<?php echo (strpos($controller, "transaction") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Transactions', 'action' => 'index']) ?>">
                            <i class="fa fa-exchange"></i> <?php echo __('Giao dịch') ?>
                        </a>
                    </li>
                    <li class="menu-parent <?php echo (strpos($controller, "user") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index']) ?>">
                            <i class="fa fa-user"></i> <?php echo __('Thành viên') ?>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'add']) ?>">
                                    <i class="fa fa-plus"></i> <?php echo __('Thêm mới') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-parent <?php echo (strpos($controller, "post") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Posts', 'action' => 'index']) ?>">
                            <i class="fa fa-file-text"></i> <?= __('Bài viết') ?>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Posts', 'action' => 'index']) ?>">
                                    <i class="fa fa-list-alt"></i> <?= __('Tất cả bài viết') ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Posts', 'action' => 'add']) ?>">
                                    <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'PostCategories', 'action' => 'index']) ?>">
                                    <i class="fa fa-th"></i> <?= __('Danh mục') ?>
                                </a>
                            </li>
                            <li class="menu-parent <?php echo (strpos($controller, "tag") !== false)?"actived":"" ?>">
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Tags', 'action' => 'index']) ?>">
                                    <i class="fa fa-tags"></i> <?php echo __('Tags/Thẻ') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-parent <?php echo (strpos($controller, "page") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Pages', 'action' => 'index']) ?>">
                            <i class="fa fa-file-text"></i> <?php echo __('Trang') ?>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Pages', 'action' => 'add']) ?>">
                                    <i class="fa fa-plus"></i> <?php echo __('Thêm mới') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo (strpos($controller, "bank") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Banks', 'action' => 'index']) ?>">
                            <i class="fa fa-bank"></i> <?php echo __('Ngân hàng') ?>
                        </a>
                    </li>
                    <li class="menu-parent <?php echo (strpos($controller, "setting") !== false)?"actived":"" ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'admin', 'controller' => 'Settings', 'action' => 'index']) ?>">
                            <i class="fa fa-cog"></i> <?php echo __('Cài đặt') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu-right pull-right">
                <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Pages', 'action' => 'display', 'home']) ?>" target="_blank">
                    <i class="fa fa-home"></i> <?= __('Trang chủ') ?>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--END: NAVIGATION-->

    <!--BEGIN: FLASH MESSAGE-->
    <div class="container flash-message"><?= $this->Flash->render() ?></div>
    <!--END: FLASH MESSAGE-->

    <!--BEGIN: MAIN CONTENT-->
    <div class="main-content">
        <?= $this->fetch('content') ?>
    </div>
    <!--END: MAIN CONTENT-->

    <!--BEGIN: FOOTER-->
    <div class="footer">
        <div class="container">
            <span>&COPY; 2018. CMS được phát triển bởi <a href="//adscript.net/">AdScript</a></span>
        </div>
    </div>
    <!--END: FOOTER-->

    <!-- Reference Scripts -->
    <?php echo $this->Html->script(['jquery.js', 'jquery-ui.min.js', 'moment.min.js'], ['type' => 'text/javascript']); ?>
    <?php echo $this->Html->script(['bootstrap.min.js', 'bootstrap-datetimepicker.min.js'], ['type' => 'text/javascript']); ?>
    <?php echo $this->Html->script(['tinymce/tinymce.min.js'], ['type' => 'text/javascript']); ?>
    <?php echo $this->Html->script(['jquery.colorbox-min.js', 'select2.min.js', 'jquery.imagefit.min.js'], ['type' => 'text/javascript']); ?>
    <?= $this->fetch('script') ?>
    <?php echo $this->Html->script('admin.js', ['type' => 'text/javascript']); ?>
</body>
</html>
