<?php
class Powers
{
    public static function owner($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || $type != 'owner') {
            header("location: index.php");
        }
    }
    public static function admin($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || ($type != 'admin' && $type != 'owner')) {
            header("location: index.php");
        }
    }
    public static function executer($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || ($type != 'execution' && $type != 'owner')) {
            header("location: index.php");
        }
    }
    public static function wereHouse($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || ($type != 'wereHouse' && $type != 'owner')) {
            header("location: index.php");
        }
    }
    public static function inspector($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || ($type != 'inspector' && $type != 'owner')) {
            header("location: index.php");
        }
    }
    public static function Safety($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail || ($type != 'safety' && $type != 'owner')) {
            header("location: index.php");
        }
    }
    public static function goTo ($account, $userEmail)
    {
        $type = $account->getAccountDetails($userEmail, null, null, null, true);

        if (!$userEmail) {
            header("location: login.php");
        } elseif ($type == 'owner') {
            header("location: ownerPage.php");
        } elseif ($type == 'admin') {
            header("location: home.php");
        } elseif ($type == 'execution') {
            header("location: notification.php");
        } elseif ($type == 'wereHouse') {
            header("location: wereHouse.php");
        } elseif ($type == 'inspector') {
            header("location: inspectorPage.php");
        } elseif ($type == 'safety') {
            header("location: Safety.php");
        }
    }
}
?>