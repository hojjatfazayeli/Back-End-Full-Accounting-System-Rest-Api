<?php

namespace App\Enums;

enum FiscalTransactionTypeEnum:string
{
    case Initial_Membership_Fee = 'initial_membership_fee'; //حق عضویت اولیه

    case MembershipـRight = 'membershipـright'; //حق اشتراک

    case Participate_Right = 'participate_right'; //حق مشارکت

    case Motivational = 'motivational'; //حق انگیزشی

}
