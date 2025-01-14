<footer id="footer-mobile">
    <div id="footer-container">
        <?php
        $isSelected = isset($currentPageFooter) && $currentPageFooter === CurrentPage::HOME;
        ?>
        <a href="/" id="home" class="redirect <?= $isSelected ? 'footer-current-page' : '' ?>"
            style="<?= $isSelected ? '' : 'color:black' ?>">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 576 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. -->
                <path
                    d="M298.6 4c-6-5.3-15.1-5.3-21.2 0L5.4 244c-6.6 5.8-7.3 16-1.4 22.6s16 7.3 22.6 1.4L64 235V432c0 44.2 35.8 80 80 80H432c44.2 0 80-35.8 80-80V235l37.4 33c6.6 5.8 16.7 5.2 22.6-1.4s5.2-16.7-1.4-22.6L298.6 4zM96 432V206.7L288 37.3 480 206.7V432c0 26.5-21.5 48-48 48H368V320c0-17.7-14.3-32-32-32H240c-17.7 0-32 14.3-32 32V480H144c-26.5 0-48-21.5-48-48zm144 48V320h96V480H240z" />
            </svg>
            <p>Accueil</p>
        </a>
        <?php
        $isSelected = isset($currentPageFooter) && $currentPageFooter === CurrentPage::RESERVATIONS;
        ?>
        <a href="/reservations.php" id="reservations" class="redirect <?= $isSelected ? 'footer-current-page' : '' ?>"
            style="<?= $isSelected ? '' : 'color:black' ?>">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 640 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. -->
                <path
                    d="M32 48c0-8.8-7.2-16-16-16S0 39.2 0 48V336v64 64c0 8.8 7.2 16 16 16s16-7.2 16-16V416H608v48c0 8.8 7.2 16 16 16s16-7.2 16-16V400 336 240c0-61.9-50.1-112-112-112H304c-26.5 0-48 21.5-48 48V320H32V48zM608 384H32V352H272 608v32zm0-144v80H288V176c0-8.8 7.2-16 16-16H528c44.2 0 80 35.8 80 80zM96 208a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm128 0A80 80 0 1 0 64 208a80 80 0 1 0 160 0z" />
            </svg>
            <p>Mes réservations</p>
        </a>
        <?php
        $isSelected = isset($currentPageFooter) && $currentPageFooter === CurrentPage::ACCOUNT;
        ?>
        <a id="account" class="<?=$isSelected ? 'footer-current-page' : '' ?>"
            style="<?= $isSelected ? '' : 'color:black' ?>">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. -->
                <path
                    d="M320 128a96 96 0 1 0 -192 0 96 96 0 1 0 192 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM32 480H416c-1.2-79.7-66.2-144-146.3-144H178.3c-80 0-145 64.3-146.3 144zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
            </svg>
            <p>Mon compte</p>
        </a>
    </div>
    <div id="footer-spacer"></div>
</footer>

<?php if (isset($currentPageFooter) && $currentPageFooter !== CurrentPage::ACCOUNT) : ?>
  <footer id="footer-desktop" style="<?php echo ($currentPageFooter === CurrentPage::BACKOFFICE) ? 'margin-left: 60px;' : ''; ?>">
  <div id="footer-left">
    <?php if (isset($currentPageFooter) && $currentPageFooter !== CurrentPage::BACKOFFICE) : ?>
      <a href="/consulter-reservations.php">Espace propriétaire</a>
    <?php else : ?>
      <a href="/index.php">Espace client</a>
    <?php endif; ?>
    <a target="_blank" href="/ressources/CGU.pdf">Mentions légales</a>
    <a href="/recherche.php">Rechercher une destination</a>
  </div>
  <div id="footer-right">
    <a>© <?php echo date("Y"); ?> BnByte, Inc.</a>
  </div>
</footer>
<?php endif; ?>
