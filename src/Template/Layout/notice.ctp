<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title><?= $title ?> - TADIEX</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('app.css') ?>
    <?= $this->Html->css('common.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="notice">
    <div class="container">
        <div id="content">
            <?= $this->Flash->render() ?>

            <div class="mb30">
                <?= $this->fetch('content') ?>
            </div>
            <p>
                <a href="<?=$this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home'])?>">
                    <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Quay về trang chủ
                </a>
            </p>
        </div>
    </div>

    <!-- Reference Scripts -->
    <?php echo $this->Html->script(['jquery.js'], ['type' => 'text/javascript']); ?>
    <?php echo $this->Html->script(['bootstrap.min.js'], ['type' => 'text/javascript']); ?>
</body>
</html>
