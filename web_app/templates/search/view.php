<?php
include __DIR__ . '/../header.php';
?>


<div class="search-name">Пошук в каталозі:</div>
<div class="search-block-container">
    <div class="search-container">
        <div class="filter-block">

            <div class="doc-left-block">
                <form id="searchForm" name="searchForm" method="post" class="search-form">
                    <div class="form-row">
                        <label for="name"> Назва документу:</label>
                        <div><input id="name" type="text" name="title"></div>
                    </div>
                    <div class="form-row">
                        <label for="author"> Автор:</label>
                        <div><input id="author" type="text" name="authors"></div>
                    </div>
                    <div class="form-row">
                        <label for="year_start"> Рік видання:</label>
                        <div><input id="year_start" type="text" name="year_start"> —
                            <input id="year_end" type="text" name="year_end"></div>
                    </div>
                    <div class="form-row">
                        <label for="lang"> Мова документу:</label>
                        <div>
                            <select id="lang" name="document_lang">
                                <option value="">Будь-яка</option>
                                <option value="eng">Англійська</option>
                                <option value="en-US">Англійська(США)</option>
                                <option value="en-US">Англійська(Канада)</option>
                                <option value="en-US">Англійська(Канада)</option>
                                <option value="en-GB">Англійська(GB)</option>
                                <option value="spa">Spanish</option>
                                <option value="fre">French</option>
                                <option value="nl">Nederlands</option>
                                <option value="ara">ara</option>
                                <option value="por">por</option>
                                <option value="ger">ger</option>
                                <option value="nor">nor</option>
                                <option value="jpn">jpn</option>
                                <option value="en">en</option>
                                <option value="vie">vie</option>
                                <option value="ind">ind</option>
                                <option value="pol">pol</option>
                                <option value="tur">tur</option>
                                <option value="dan">dan</option>
                                <option value="fil">fil</option>
                                <option value="ita">ita</option>
                                <option value="per">per</option>
                                <option value="swe">swe</option>
                                <option value="rum">rum</option>
                                <option value="mul">mul</option>
                                <option value="rus">rus</option>
                            </select>
                        </div>
                    </div>


            </div>

            <div class="doc-right-block">
                <div class="themes-filter">
                    <div></div>
                    <ul class="genres_container">
                        <?php
                        foreach ($genres as $genre) {
                            echo '<li class="genre">' . $genre['genre'] . '<input style="display: none" class="input-class"  type="checkbox" name="genre_id[]" value="' . $genre['genre_id'] . '"></li>';
                        }


                        ?>
                    </ul>
                </div>
                </form>


            </div>

        </div>

    </div>
    <div class="button-container-search">
        <button id="submit1" type="button">Пошук</button>
    </div>

</div>


<div id="result_docs" class="results-block">


</div>

</div>

<script>
    $(".genre").each(function () {
        if ($(this).children(".input-class").prop("checked") === true) {
            $(this).css('background-color', 'black');
            $(this).css('color', 'white');
        }
    })

    $('.genre').click(function (event) {
        if ($(this).children(".input-class").prop("checked") === true) {
            $(this).children(".input-class").prop("checked", false);
            $(this).children().find(".input-class").prop("checked", false);
            $(this).css('background-color', 'white');
            $(this).css('color', 'black');

        } else {
            $(this).children(".input-class").prop("checked", true);
            $(this).css('background-color', 'black');
            $(this).css('color', 'white');
        }

        $(this).children("ul>ul").slideToggle('fast');

        event.stopPropagation();
    });

</script>


<script src="https://code.jsqlQuery.com/jsqlQuery-3.5.0.js"></script>
<script src="/www/search.js"></script>
