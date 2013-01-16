    <header>
        <table>
            <tr>
                <td class="logo"><?php echo link_to(image_tag('emtlogo.gif', 'style=width:160px;'), '@camp.homepage') ?></td>
                <td><span><?php echo __('Already a member? %1sginlink - %2fpsslink', array('%1sginlink' => link_to(__('Sign in here'), '@login', 'class=inherit-font bluelink hover'),
                                                                                   '%2fpsslink' => link_to(__('Forgot Password?'), '@forgot-password', 'class=inherit-font bluelink hover'))) ?></span></td>
            </tr>
        </table>
        <div class="liner">
    </header>
