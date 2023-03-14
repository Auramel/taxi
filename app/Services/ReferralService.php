<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\TgUser;

class ReferralService
{
    public function create(
        TgUser $incomeTgUser,
        TgUser $fromTgUser,
    )
    {
        if (
            empty($fromTgUser)
            || $fromTgUser->id === $incomeTgUser->id
        ) {
            return;
        }

        $isReferral = Referral::whereIncomeTgUserId($incomeTgUser->id)
            ->first();

        if (empty($isReferral)) {
            $referral = new Referral();
            $referral->income_tg_user_id = $incomeTgUser->id;
            $referral->from_tg_user_id = $fromTgUser->id;
            $referral->level = 1;
            $referral->save();

            $this->calculateLevels(
                incomeTgUser: $incomeTgUser,
                fromTgUser: $fromTgUser,
            );
        }
    }

    public function calculateLevels(
        TgUser $incomeTgUser,
        TgUser $fromTgUser,
        int $level = 2,
    )
    {
        $referral = Referral::whereIncomeTgUserId($fromTgUser->id)
            ->select(['id', 'from_tg_user_id'])
            ->whereLevel(1)
            ->first();

        if (empty($referral)) {
            return;
        }

        $newReferral = new Referral();
        $newReferral->income_tg_user_id = $incomeTgUser->id;
        $newReferral->from_tg_user_id = $referral->from_tg_user_id;
        $newReferral->level = $level;
        $newReferral->save();

        $this->calculateLevels(
            incomeTgUser: $incomeTgUser,
            fromTgUser: $referral->fromTgUser,
            level: $level + 1,
        );
    }
}
