<?php include __DIR__ . '/../header.php'; ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="/www/user-analytic.js"></script>
<div class="profile-container">
    <div class="profile-info">
        <div class="profile-image-block"><img id="profile-image" class="profile-image"
                                              src="/src/includes/icons/avatar.png"></div>
        <div class="profile-name-main"><?= $user->getNickName() ?></div>
        <div class="profile-telemetry">
            <div class="views-container"><img class="img-tlmtr" src="/src/includes/icons/glasses.svg">
                <div class="views"><?= $user->getCountViews() ?></div>
            </div>
            <div class="likes-container"><img class="img-tlmtr" src="/src/includes/icons/heart.svg">
                <div class="views">10</div>
            </div>
            <div class="downloads-container"><img class="img-tlmtr" src="/src/includes/icons/download-1.svg">
                <div class="views"><?= $user->getCountDownloads() ?></div>
            </div>

        </div>
    </div>

    <div class="profile-statistic">

        <h1 class="graph-name">Views Activity</h1>
        <div class="chart" id="calendar_basic" style=" height: 200px;"></div>
        <h1 class="graph-name">Rates Activity</h1>
        <div class="chart" id="calendar_basic2" style=" height: 200px;"></div>

    </div>
</div>


<div id="edit-profile-form" class="form-container">
    <form class="form">
        <ul class="flex-outer">
            <li>
                <label for="first-name">Ім'я</label>
                <input type="text" id="first-name">
            </li>
            <li>
                <label for="email">Email</label>
                <input type="email" id="email">
            </li>
            <li class="buttons">
                <button type="submit">Підтвердити</button>
                <button id="close-edit-profile-form" type="button">Закрити</button>
            </li>
        </ul>
    </form>
</div>


<script>
    let image = document.getElementById('profile-image');
    let form = document.getElementById('edit-profile-form');
    let closeForm = document.getElementById('close-edit-profile-form');
    closeForm.addEventListener('click', event => {
        form.style.display = 'none';
    });
    image.addEventListener('click', event => {
        form.style.display = 'flex';
    });

</script>