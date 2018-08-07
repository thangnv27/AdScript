<div class="dashboard-nav-list">
    <div class="row">
        <div class="col-sm-3">
            <div class="nav-item trades-opening <?php echo ($this->request->params['action']=='index')?"active":"" ?>">
                <a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'index'])?>">Giao dịch đang mở</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="nav-item trades-closed <?php echo ($this->request->params['action']=='tradesClosed')?"active":"" ?>">
                <a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'tradesClosed'])?>">Giao dịch đã đóng</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="nav-item my-offers <?php echo (in_array($this->request->params['action'], array('myOffers', 'createSell', 'createBuy')))?"active":"" ?>">
                <a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'myOffers'])?>">Quảng cáo của tôi</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="nav-item referral <?php echo ($this->request->params['action']=='referral')?"active":"" ?>">
                <a href="<?=$this->Url->build(['controller' => 'Dashboard', 'action' => 'referral'])?>">Danh sách giới thiệu</a>
            </div>
        </div>
    </div>
</div>