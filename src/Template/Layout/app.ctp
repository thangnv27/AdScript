<?php
$controller = strtolower($this->request->params['controller']);
$action = strtolower($this->request->params['action']);
$pass = $this->request->params['pass'];
?>
<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<title><?= $title ?> - AdScript</title>
<meta name="robots" content="noindex, nofollow" /> 
<meta name="googlebot" content="noindex, nofollow" />
<meta name="bingbot" content="noindex, nofollow" />
<?= $this->Html->meta('icon') ?>

<?= $this->Html->css('bootstrap.min.css') ?>
<?= $this->Html->css('font-awesome.min.css') ?>
<?= $this->Html->css('app.css') ?>
<?= $this->Html->css('common.css') ?>

<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<script>
    var siteUrl = "<?php echo SITE_URL ?>";
    var is_home = <?php echo ($controller=="pages" and $action=="display" and $pass[0]=="home")?"true":"false"; ?>;
    var is_mobile = false;
    var is_auth = <?php echo ($this->request->session()->read('Auth.User.username'))?"true":"false" ?>;
</script>
</head>
<body class="app">
<div class="container">
    <div id="content">
        <?= $this->Flash->render() ?>

        <h1 class="text-center mt0 mb30 uppercase"><?= $title ?></h1>
        <?= $this->fetch('content') ?>
        <p class="text-center mt30">
            <a href="<?=$this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home'])?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Quay về trang chủ
            </a>
        </p>
    </div>
</div>

<!-- Reference Scripts -->
<?php echo $this->Html->script(['jquery.js'], ['type' => 'text/javascript']); ?>
<?php echo $this->Html->script(['bootstrap.min.js'], ['type' => 'text/javascript']); ?>
<?php echo $this->Html->script('wow.min.js', ['type' => 'text/javascript']); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<?php echo $this->Html->script(['app.js'], ['type' => 'text/javascript']); ?>
</body>
</html>
