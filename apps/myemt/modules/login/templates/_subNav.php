    <header>
        <table>
            <tr>
                <td class="logo"><?php echo link_to(image_tag('emtlogo.gif', 'style=width:160px;'), '@lobby.homepage') ?></td>
                <td><span><?php echo __('Welcome! Please %1calink or %2sginlink.', array('%1calink' => link_to(__('create an account'), '@signup', 'class=inherit-font bluelink hover'),
                                                                                   '%2sginlink' => link_to(__('sign in'), '@login', 'class=inherit-font bluelink hover'))) ?></span></td>
            </tr>
        </table>
        <div class="liner">
    </header>
