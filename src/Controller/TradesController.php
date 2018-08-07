<?php

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class TradesController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
    /**
     * Giao dich mua WEX
     * @param int $id Offer ID
     */
    public function buy($id){
        $status = "error";
        $message = __("Xảy ra lỗi!");
        $offer_table = TableRegistry::get('offers');
        $offer = $this->Trades->Offers->find('all', array(
                'conditions' => array(
                    'Offers.id' => $id,
                )
            ))->contain(['Users'])->first();
        if($offer){
            $curent_user = $this->Auth->user();
            $curent_user = $this->Trades->Offers->Users->find('all', array(
                'conditions' => array(
                    'Users.id' => $curent_user->id,
                )
            ))->contain(['Wallets', 'UserMeta'])->first();
            
            if($curent_user->email_confirmed != 1 or $curent_user->user_metum->passport_confirmed != 1 or $curent_user->user_metum->phone_confirmed != 1){
                $message = __("Bạn cần xác minh tài khoản trước khi thực hiện giao dịch này!");
            } else {
                $offer_user = $this->Trades->Offers->Users->find('all', array(
                    'conditions' => array(
                        'Users.id' => $offer->user_id,
                    )
                ))->contain(['Wallets', 'UserMeta'])->first();

                // xu ly giao dich
                if ($this->request->is('post')) {
                    $wallet_table = TableRegistry::get('wallets');
                    $wallet_offer_user = $wallet_table->get($offer_user->id);
                    $wallet_curent_user = $wallet_table->get($curent_user->id);
                    $amount = floatval($this->request->data('amount'));
                    $fiat_amount_offer = $amount * $offer->price;
                    $fiat_amount_current = $amount * $offer->price_view;

                    if($amount < $offer->min_amount or $amount > $offer->max_amount){
                        $message = __('Số tiền phải >= {0} hoặc <= {1}!', [$offer->min_amount, $offer->max_amount]);
                    } else if($wallet_offer_user->usd < $amount){
                        $message = __('Người bán không có đủ số dư cho giao dịch này!');
                    } else if($wallet_curent_user->vnd < $fiat_amount_current){
                        $message = __('Bạn không có đủ số dư cho giao dịch này!');
                    } else {
                        // Người bán
                        $trade_sell = $this->Trades->newEntity();
                        $trade_sell->trade_type = "sell";
                        $trade_sell->offer_id = $offer->id;
                        $trade_sell->user_id = $offer_user->id; // Nguoi ban
                        $trade_sell->user_id2 = $curent_user->id; // Nguoi mua
                        $trade_sell->amount = $amount;
                        $trade_sell->fiat_amount = $fiat_amount_offer;
                        $trade_sell->status = 1;

                        $wallet_offer_user->usd = $wallet_offer_user->usd - $amount;
                        $wallet_offer_user->vnd = $wallet_offer_user->vnd + $fiat_amount_offer;

                        // Người mua
                        $trade_buy = $this->Trades->newEntity();
                        $trade_buy->trade_type = "buy";
                        $trade_buy->offer_id = $offer->id;
                        $trade_buy->user_id = $curent_user->id; // Nguoi mua
                        $trade_buy->user_id2 = $offer_user->id; // Nguoi ban
                        $trade_buy->amount = $amount;
                        $trade_buy->fiat_amount = $fiat_amount_current;
                        $trade_buy->status = 1;

                        $wallet_curent_user->usd = $wallet_curent_user->usd + $amount;
                        $wallet_curent_user->vnd = $wallet_curent_user->vnd - $fiat_amount_current;

                        // Save data
                        $this->Trades->saveMany(array($trade_sell, $trade_buy));
                        $wallet_table->saveMany(array($wallet_offer_user, $wallet_curent_user));

                        $status = "success";
                        $message = __('Chúc mừng bạn! Giao dịch thành công.');
                    }
                }
            }
        }
        
        echo json_encode(array(
            'status' => $status,
            'message' => $message,
        ));
        exit;
    }
    
    /**
     * Giao dich ban WEX
     * @param int $id Offer ID
     */
    public function sell($id){
        $status = "error";
        $message = __("Xảy ra lỗi!");
        $offer = $this->Trades->Offers->find('all', array(
                'conditions' => array(
                    'Offers.id' => $id,
                )
            ))->contain(['Users'])->first();
        if($offer){
            $curent_user = $this->Auth->user();
            $curent_user = $this->Trades->Offers->Users->find('all', array(
                'conditions' => array(
                    'Users.id' => $curent_user->id,
                )
            ))->contain(['Wallets', 'UserMeta'])->first();
            
            if($curent_user->email_confirmed != 1 or $curent_user->user_metum->passport_confirmed != 1 or $curent_user->user_metum->phone_confirmed != 1){
                $message = __("Bạn cần xác minh tài khoản trước khi thực hiện giao dịch này!");
            } else {
                $offer_user = $this->Trades->Offers->Users->find('all', array(
                    'conditions' => array(
                        'Users.id' => $offer->user_id,
                    )
                ))->contain(['Wallets', 'UserMeta'])->first();

                // xu ly giao dich
                if ($this->request->is('post')) {
                    $wallet_table = TableRegistry::get('wallets');
                    $wallet_offer_user = $wallet_table->get($offer_user->id);
                    $wallet_curent_user = $wallet_table->get($curent_user->id);
                    $amount = floatval($this->request->data('amount'));
                    $fiat_amount_offer = $amount * $offer->price;
                    $fiat_amount_current = $amount * $offer->price_view;

                    if($amount < $offer->min_amount or $amount > $offer->max_amount){
                        $message = __('Số tiền phải >= {0} hoặc <= {1}!', [$offer->min_amount, $offer->max_amount]);
                    } else if($wallet_curent_user->usd < $amount){
                        $message = __('Bạn không có đủ số dư cho giao dịch này!');
                    } else if($wallet_offer_user->vnd < $fiat_amount_offer){
                        $message = __('Người mua không có đủ số dư cho giao dịch này!');
                    } else {
                        // Người mua
                        $trade_sell = $this->Trades->newEntity();
                        $trade_sell->trade_type = "buy";
                        $trade_sell->offer_id = $offer->id;
                        $trade_sell->user_id = $offer_user->id; // Nguoi mua
                        $trade_sell->user_id2 = $curent_user->id; // Nguoi ban
                        $trade_sell->amount = $amount;
                        $trade_sell->fiat_amount = $fiat_amount_offer;
                        $trade_sell->status = 1;

                        $wallet_offer_user->usd = $wallet_offer_user->usd + $amount;
                        $wallet_offer_user->vnd = $wallet_offer_user->vnd - $fiat_amount_offer;

                        // Người bán
                        $trade_buy = $this->Trades->newEntity();
                        $trade_buy->trade_type = "sell";
                        $trade_buy->offer_id = $offer->id;
                        $trade_buy->user_id = $curent_user->id; // Nguoi ban
                        $trade_buy->user_id2 = $offer_user->id; // Nguoi mua
                        $trade_buy->amount = $amount;
                        $trade_buy->fiat_amount = $fiat_amount_current;
                        $trade_buy->status = 1;

                        $wallet_curent_user->usd = $wallet_curent_user->usd - $amount;
                        $wallet_curent_user->vnd = $wallet_curent_user->vnd + $fiat_amount_current;

                        // Save data
                        $this->Trades->saveMany(array($trade_sell, $trade_buy));
                        $wallet_table->saveMany(array($wallet_offer_user, $wallet_curent_user));

                        $status = "success";
                        $message = __('Chúc mừng bạn! Giao dịch thành công.');
                    }
                }
            }
        }
        
        echo json_encode(array(
            'status' => $status,
            'message' => $message,
        ));
        exit;
    }

}
