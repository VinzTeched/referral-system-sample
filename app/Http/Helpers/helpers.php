<?php

    function levelCommission($id, $amount, $commissionType = '')
    {
        $usr = $id;
        $user = \App\Models\User::find($id);
        $i = 1;

        $level = \App\Models\Referral::where('commission_type',$commissionType)->count();

        while ($usr != "" || $usr != "0" || $i < $level) {
            $me = \App\Models\User::find($usr);
            $refer = \App\Models\User::find($me->referral);

            if ($refer == "") {
                break;
            }
            $commission = \App\Referral::where('commission_type', $commissionType)->where('level', $i)->first();
            if (!$commission) {
                break;
            }
            $com = ($amount * $commission->percent) / 100;


            $referWallet = $refer;
            $new_bal = getAmount($referWallet->interest_wallet + $com);
            $referWallet->interest_wallet = $new_bal;
            $referWallet->save();

            $trx = getTrx();


            $transaction = new \App\Transaction();
            $transaction->user_id = $refer->id;
            $transaction->amount = getAmount($com);
            $transaction->post_balance = $new_bal;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details =' level '.$i.' Referral Commission From ' . $user->username;
            $transaction->trx = $trx;
            $transaction->wallet_type =  'interest_wallet';
            $transaction->save();


            $usr = $refer->id;
            $i++;
        }
        return 0;
    }

    function getAmount($amount, $length = 0)
    {
        if (0 < $length) {
            return number_format($amount + 0, $length);
        }
        return $amount + 0;
    }

    function getTrx($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }