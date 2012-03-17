<table class="sticker user">
<tr><td><?php echo link_to(image_tag($user->getProfilePictureUri()), $user->getProfileUrl()) ?></td>
<td><b><?php echo link_to($user, $user->getProfileUrl()) ?></b>
    <div class="t_grey">
        <?php echo ($user->getContact() ? ($user->getContact()->getWorkAddress() ? format_country($user->getContact()->getWorkAddress()->getCountry()) : $user->getContact()->getHomeAddress() ? format_country($user->getContact()->getHomeAddress()->getCountry()) : '') : '') ?>
    </div></td></tr>
</table>