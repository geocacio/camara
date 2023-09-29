<style>
    .list-icons {
        padding: 0;
        margin: 0;
        list-style: none;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 15px;
    }

    @media(min-width: 590px) {
        .list-icons {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media(min-width: 991px) {
        .list-icons {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .list-icons li {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        cursor: pointer;
        color: #1E3050;
        padding: 4px 0;
        border-radius: 5px;
        text-align: center;
    }

    .list-icons li:hover {
        background-color: #47565d;
        color: #fff;
    }

    .list-icons li i {
        pointer-events: none;
    }
</style>

<ul class="list-icons">
    <li><i class="fa-solid fa-hand-holding-dollar"></i>fa-dollar</li>
    <li><i class="fa-solid fa-face-smile"></i>fa-face-smile</li>
    <li><i class="fas fa-users"></i>fa-users</li>
    <li><i class="fas fa-user"></i>fa-user</li>
    <li><i class="fas fa-user-circle"></i>fa-user-circle</li>
    <li><i class="fas fa-user-astronaut"></i>fa-user-astronaut</li>
    <li><i class="fas fa-user-clock"></i>fa-user-clock</li>
    <li><i class="fas fa-user-cog"></i>fa-user-cog</li>
    <li><i class="fas fa-user-edit"></i>fa-user-edit</li>
    <li><i class="fas fa-user-friends"></i>fa-user-friends</li>
    <li><i class="fas fa-user-graduate"></i>fa-user-graduate</li>
    <li><i class="fas fa-home"></i>fa-home</li>
    <li><i class="fa-solid fa-envelope"></i>fa-envelope</li>
    <li><i class="fa-regular fa-envelope"></i>fa-envelope-regular</li>
    <li><i class="fa-solid fa-circle-info"></i>fa-circle-info</li>
    <li><i class="fas fa-building"></i>fa-building</li>
    <li><i class="fas fa-city"></i>fa-city</li>
    <li><i class="fas fa-hospital"></i>fa-hospital</li>
    <li><i class="fas fa-school"></i>fa-school</li>
    <li><i class="fas fa-warehouse"></i>fa-warehouse</li>
    <li><i class="fas fa-car"></i>fa-car</li>
    <li><i class="fas fa-truck"></i>fa-truck</li>
    <li><i class="fas fa-bus"></i>fa-bus</li>
    <li><i class="fas fa-motorcycle"></i>fa-motorcycle</li>
    <li><i class="fas fa-bicycle"></i>fa-bicycle</li>
    <li><i class="fas fa-train"></i>fa-train</li>
    <li><i class="fas fa-subway"></i>fa-subway</li>
    <li><i class="fas fa-tram"></i>fa-tram</li>
    <li><i class="fas fa-car-alt"></i>fa-car-alt</li>
    <li><i class="fas fa-file"></i>fa-file</li>
    <li><i class="fas fa-file-alt"></i>fa-file-alt</li>
    <li><i class="fas fa-file-archive"></i>fa-file-archive</li>
    <li><i class="fas fa-file-audio"></i>fa-file-audio</li>
    <li><i class="fas fa-file-code"></i>fa-file-code</li>
    <li><i class="fas fa-file-excel"></i>fa-file-excel</li>
    <li><i class="fas fa-file-image"></i>fa-file-image</li>
    <li><i class="fas fa-file-pdf"></i>fa-file-pdf</li>
    <li><i class="fas fa-file-powerpoint"></i>fa-file-powerpoint</li>
    <li><i class="fas fa-file-video"></i>fa-file-video</li>
    <li><i class="fas fa-file-word"></i>fa-file-word</li>
    <li><i class="fas fa-file-medical"></i>fa-file-medical</li>
    <li><i class="fas fa-file-prescription"></i>fa-file-prescription</li>
    <li><i class="fas fa-file-signature"></i>fa-file-signature</li>
    <li><i class="fas fa-file-csv"></i>fa-file-csv</li>
    <li><i class="fas fa-file-code"></i>fa-file-code</li>
    <li><i class="fas fa-plus"></i>fa-plus</li>
    <li><i class="fas fa-plus-circle"></i>fa-plus-circle</li>
    <li><i class="fas fa-plus-square"></i>fa-plus-square</li>
    <li><i class="fas fa-address-book icon"></i>fa-address-book</li>
    <li><i class="fas fa-address-card icon"></i>fa-address-card</li>
    <li><i class="fas fa-adjust icon"></i>fa-adjust</li>
    <li><i class="fas fa-align-center icon"></i>fa-align-center</li>
    <li><i class="fas fa-align-justify icon"></i>fa-align-justify</li>
    <li><i class="fas fa-align-left icon"></i>fa-align-left</li>
    <li><i class="fas fa-align-right icon"></i>fa-align-right</li>
    <li><i class="fas fa-allergies icon"></i>fa-allergies</li>
    <li><i class="fas fa-ambulance icon"></i>fa-ambulance</li>
    <li><i class="fas fa-american-sign-language-interpreting icon"></i>fa-american-sign-language-interpreting</li>
    <li><i class="fas fa-anchor icon"></i>fa-anchor</li>
    <li><i class="fas fa-angle-double-down icon"></i>fa-angle-double-down</li>
    <li><i class="fas fa-angle-double-left icon"></i>fa-angle-double-left</li>
    <li><i class="fas fa-angle-double-right icon"></i>fa-angle-double-right</li>
    <li><i class="fas fa-angle-double-up icon"></i>fa-angle-double-up</li>
    <li><i class="fas fa-angle-down icon"></i>fa-angle-down</li>
    <li><i class="fas fa-angle-left icon"></i>fa-angle-left</li>
    <li><i class="fas fa-angle-right icon"></i>fa-angle-right</li>
    <li><i class="fas fa-angle-up icon"></i>fa-angle-up</li>
    <li><i class="fas fa-angry icon"></i>fa-angry</li>
    <li><i class="fas fa-ankh icon"></i>fa-ankh</li>
    <li><i class="fas fa-apple-alt icon"></i>fa-apple-alt</li>
    <li><i class="fas fa-archway icon"></i>fa-archway</li>
    <li><i class="fas fa-atom icon"></i>fa-atom</li>
    <li><i class="fas fa-baby icon"></i>fa-baby</li>
    <li><i class="fas fa-balance-scale icon"></i>fa-balance-scale</li>
    <li><i class="fas fa-ban icon"></i>fa-ban</li>
    <li><i class="fas fa-band-aid icon"></i>fa-band-aid</li>
    <li><i class="fas fa-baseball-ball icon"></i>fa-baseball-ball</li>
    <li><i class="fas fa-basketball-ball icon"></i>fa-basketball-ball</li>
    <li><i class="fas fa-bed icon"></i>fa-bed</li>
    <li><i class="fas fa-bell icon"></i>fa-bell</li>
    <li><i class="fas fa-bicycle icon"></i>fa-bicycle</li>
    <li><i class="fas fa-binoculars icon"></i>fa-binoculars</li>
    <li><i class="fas fa-birthday-cake icon"></i>fa-birthday-cake</li>
    <li><i class="fas fa-blender icon"></i>fa-blender</li>
    <li><i class="fas fa-bone icon"></i>fa-bone</li>
    <li><i class="fas fa-bong icon"></i>fa-bong</li>
    <li><i class="fas fa-book icon"></i>fa-book</li>
    <li><i class="fas fa-bowling-ball icon"></i>fa-bowling-ball</li>
    <li><i class="fas fa-brain icon"></i>fa-brain</li>
    <li><i class="fas fa-briefcase icon"></i>fa-briefcase</li>
    <li><i class="fas fa-broom icon"></i>fa-broom</li>
    <li><i class="fas fa-brush icon"></i>fa-brush</li>
    <li><i class="fas fa-bug icon"></i>fa-bug</li>
    <li><i class="fas fa-building icon"></i>fa-building</li>
    <li><i class="fas fa-bus icon"></i>fa-bus</li>
    <li><i class="fas fa-calculator icon"></i>fa-calculator</li>
    <li><i class="fas fa-camera icon"></i>fa-camera</li>
    <li><i class="fas fa-candy-cane icon"></i>fa-candy-cane</li>
    <li><i class="fas fa-car icon"></i>fa-car</li>
    <li><i class="fas fa-carrot icon"></i>fa-carrot</li>
    <li><i class="fas fa-cat icon"></i>fa-cat</li>
    <li><i class="fas fa-chair icon"></i>fa-chair</li>
    <li><i class="fas fa-chess icon"></i>fa-chess</li>
    <li><i class="fas fa-church icon"></i>fa-church</li>
    <li><i class="fas fa-circle icon"></i>fa-circle</li>
    <li><i class="fas fa-cloud icon"></i>fa-cloud</li>
    <li><i class="fas fa-cocktail icon"></i>fa-cocktail</li>
    <li><i class="fas fa-coffee icon"></i>fa-coffee</li>
    <li><i class="fas fa-coins icon"></i>fa-coins</li>
    <li><i class="fas fa-cookie icon"></i>fa-cookie</li>
    <li><i class="fas fa-crown icon"></i>fa-crown</li>
    <li><i class="fas fa-cube icon"></i>fa-cube</li>
    <li><i class="fas fa-cut icon"></i>fa-cut</li>
    <li><i class="fas fa-dice icon"></i>fa-dice</li>
    <li><i class="fas fa-dog icon"></i>fa-dog</li>
    <li><i class="fas fa-dove icon"></i>fa-dove</li>
    <li><i class="fas fa-dragon icon"></i>fa-dragon</li>
    <li><i class="fas fa-drum icon"></i>fa-drum</li>
    <li><i class="fas fa-feather icon"></i>fa-feather</li>
    <li><i class="fas fa-fire icon"></i>fa-fire</li>
    <li><i class="fas fa-fish icon"></i>fa-fish</li>
    <li><i class="fas fa-flag icon"></i>fa-flag</li>
    <li><i class="fas fa-flask icon"></i>fa-flask</li>
    <li><i class="fas fa-football-ball icon"></i>fa-football-ball</li>
    <li><i class="fas fa-frog icon"></i>fa-frog</li>
    <li><i class="fas fa-gamepad icon"></i>fa-gamepad</li>
    <li><i class="fas fa-gem icon"></i>fa-gem</li>
    <li><i class="fas fa-gift icon"></i>fa-gift</li>
    <li><i class="fas fa-glasses icon"></i>fa-glasses</li>
    <li><i class="fas fa-guitar icon"></i>fa-guitar</li>
    <li><i class="fas fa-hammer icon"></i>fa-hammer</li>
    <li><i class="fas fa-hat-wizard icon"></i>fa-hat-wizard</li>
    <li><i class="fas fa-heart icon"></i>fa-heart</li>
    <li><i class="fas fa-hiking icon"></i>fa-hiking</li>
    <li><i class="fas fa-holly-berry icon"></i>fa-holly-berry</li>
    <li><i class="fas fa-home icon"></i>fa-home</li>
    <li><i class="fas fa-horse icon"></i>fa-horse</li>
    <li><i class="fas fa-hourglass icon"></i>fa-hourglass</li>
    <li><i class="fas fa-ice-cream icon"></i>fa-ice-cream</li>
    <li><i class="fas fa-igloo icon"></i>fa-igloo</li>
    <li><i class="fas fa-key icon"></i>fa-key</li>
    <li><i class="fas fa-laptop icon"></i>fa-laptop</li>
    <li><i class="fas fa-lemon icon"></i>fa-lemon</li>
    <li><i class="fas fa-life-ring icon"></i>fa-life-ring</li>
    <li><i class="fas fa-lightbulb icon"></i>fa-lightbulb</li>
    <li><i class="fas fa-mask icon"></i>fa-mask</li>
    <li><i class="fa-solid fa-phone"></i>fa-solid fa-phone</li>
    <li><i class="fas fa-microphone icon"></i>fa-microphone</li>
    <li><i class="fas fa-mountain icon"></i>fa-mountain</li>
    <li><i class="fas fa-music icon"></i>fa-music</li>
    <li><i class="fas fa-paint-brush icon"></i>fa-paint-brush</li>
    <li><i class="fas fa-paper-plane icon"></i>fa-paper-plane</li>
    <li><i class="fas fa-paw icon"></i>fa-paw</li>
    <li><i class="fas fa-peace icon"></i>fa-peace</li>
    <li><i class="fas fa-pizza-slice icon"></i>fa-pizza-slice</li>
    <li><i class="fas fa-poo icon"></i>fa-poo</li>
    <li><i class="fas fa-quidditch icon"></i>fa-quidditch</li>
    <li><i class="fas fa-rabbit icon"></i>fa-rabbit</li>
    <li><i class="fas fa-rocket icon"></i>fa-rocket</li>
    <li><i class="fas fa-ruler icon"></i>fa-ruler</li>
    <li><i class="fas fa-running icon"></i>fa-running</li>
    <li><i class="fas fa-satellite icon"></i>fa-satellite</li>
    <li><i class="fas fa-shield-alt icon"></i>fa-shield-alt</li>
    <li><i class="fas fa-skull icon"></i>fa-skull</li>
    <li><i class="fas fa-snowflake icon"></i>fa-snowflake</li>
    <li><i class="fas fa-spider icon"></i>fa-spider</li>
    <li><i class="fas fa-sun icon"></i>fa-sun</li>
    <li><i class="fas fa-swimmer icon"></i>fa-swimmer</li>
    <li><i class="fas fa-tennis-ball icon"></i>fa-tennis-ball</li>
    <li><i class="fas fa-toilet-paper icon"></i>fa-toilet-paper</li>
    <li><i class="fas fa-tree icon"></i>fa-tree</li>
    <li><i class="fas fa-umbrella icon"></i>fa-umbrella</li>
    <li><i class="fas fa-volleyball-ball icon"></i>fa-volleyball-ball</li>
    <li><i class="fas fa-walking icon"></i>fa-walking</li>
    <li><i class="fas fa-watermelon icon"></i>fa-watermelon</li>
    <li><i class="fas fa-wifi icon"></i>fa-wifi</li>
    <li><i class="fas fa-yin-yang icon"></i>fa-yin-yang</li>
    <li><i class="fas fa-zebra icon"></i>fa-zebra</li>
    <li><i class="fas fa-bolt icon"></i>fa-bolt</li>
    <li><i class="fas fa-bowling-pins icon"></i>fa-bowling-pins</li>
    <li><i class="fas fa-campground icon"></i>fa-campground</li>
    <li><i class="fas fa-chess-bishop icon"></i>fa-chess-bishop</li>
    <li><i class="fas fa-chess-king icon"></i>fa-chess-king</li>
    <li><i class="fas fa-chess-knight icon"></i>fa-chess-knight</li>
    <li><i class="fas fa-chess-pawn icon"></i>fa-chess-pawn</li>
    <li><i class="fas fa-chess-queen icon"></i>fa-chess-queen</li>
    <li><i class="fas fa-chess-rook icon"></i>fa-chess-rook</li>
    <li><i class="fas fa-cloud-moon icon"></i>fa-cloud-moon</li>
    <li><i class="fas fa-cloud-sun icon"></i>fa-cloud-sun</li>
    <li><i class="fas fa-comet icon"></i>fa-comet</li>
    <li><i class="fas fa-crow icon"></i>fa-crow</li>
    <li><i class="fas fa-dharmachakra icon"></i>fa-dharmachakra</li>
    <li><i class="fas fa-dice-d20 icon"></i>fa-dice-d20</li>
    <li><i class="fas fa-dice-d6 icon"></i>fa-dice-d6</li>
    <li><i class="fas fa-dragonfly icon"></i>fa-dragonfly</li>
    <li><i class="fas fa-feather-alt icon"></i>fa-feather-alt</li>
    <li><i class="fas fa-file-contract icon"></i>fa-file-contract</li>
    <li><i class="fas fa-frog"></i>fa-frog</li>
    <li><i class="fas fa-galaxy"></i>fa-galaxy</li>
    <li><i class="fas fa-gem"></i>fa-gem</li>
    <li><i class="fas fa-ghost"></i>fa-ghost</li>
    <li><i class="fas fa-globe"></i>fa-globe</li>
    <li><i class="fas fa-hammer"></i>fa-hammer</li>
    <li><i class="fas fa-hat-cowboy"></i>fa-hat-cowboy</li>
    <li><i class="fas fa-hat-wizard"></i>fa-hat-wizard</li>
    <li><i class="fas fa-headphones"></i>fa-headphones</li>
    <li><i class="fas fa-helicopter"></i>fa-helicopter</li>
    <li><i class="fas fa-hippo"></i>fa-hippo</li>
    <li><i class="fas fa-horse"></i>fa-horse</li>
    <li><i class="fas fa-hourglass"></i>fa-hourglass</li>
    <li><i class="fas fa-hiking"></i>fa-hiking</li>
    <li><i class="fas fa-ice-cream"></i>fa-ice-cream</li>
    <li><i class="fas fa-igloo"></i>fa-igloo</li>
    <li><i class="fas fa-jedi"></i>fa-jedi</li>
    <li><i class="fas fa-kiwi-bird"></i>fa-kiwi-bird</li>
    <li><i class="fas fa-laptop"></i>fa-laptop</li>
    <li><i class="fas fa-lemon"></i>fa-lemon</li>
    <li><i class="fas fa-life-ring"></i>fa-life-ring</li>
    <li><i class="fas fa-magic"></i>fa-magic</li>
    <li><i class="fas fa-map-marked"></i>fa-map-marked</li>
    <li><i class="fas fa-mask"></i>fa-mask</li>
    <li><i class="fas fa-meteor"></i>fa-meteor</li>
    <li><i class="fas fa-mountain"></i>fa-mountain</li>
    <li><i class="fas fa-music"></i>fa-music</li>
    <li><i class="fas fa-narwhal"></i>fa-narwhal</li>
    <li><i class="fas fa-ninja"></i>fa-ninja</li>
    <li><i class="fas fa-otter"></i>fa-otter</li>
    <li><i class="fas fa-paper-plane"></i>fa-paper-plane</li>
    <li><i class="fas fa-paw"></i>fa-paw</li>
    <li><i class="fas fa-pepper-hot"></i>fa-pepper-hot</li>
    <li><i class="fas fa-people-carry"></i>fa-people-carry</li>
    <li><i class="fas fa-pizza-slice"></i>fa-pizza-slice</li>
    <li><i class="fas fa-praying-hands"></i>fa-praying-hands</li>
    <li><i class="fas fa-quidditch"></i>fa-quidditch</li>
    <li><i class="fas fa-rabbit"></i>fa-rabbit</li>
    <li><i class="fas fa-rainbow"></i>fa-rainbow</li>
    <li><i class="fas fa-ring"></i>fa-ring</li>
    <li><i class="fas fa-robot"></i>fa-robot</li>
    <li><i class="fas fa-rocket"></i>fa-rocket</li>
    <li><i class="fas fa-route"></i>fa-route</li>
    <li><i class="fas fa-ruler"></i>fa-ruler</li>
    <li><i class="fas fa-satellite"></i>fa-satellite</li>
    <li><i class="fas fa-seedling"></i>fa-seedling</li>
    <li><i class="fas fa-shield-alt"></i>fa-shield-alt</li>
    <li><i class="fas fa-snowflake"></i>fa-snowflake</li>
    <li><i class="fas fa-space-shuttle"></i>fa-space-shuttle</li>
    <li><i class="fas fa-spider"></i>fa-spider</li>
    <li><i class="fas fa-star"></i>fa-star</li>
    <li><i class="fas fa-sun"></i>fa-sun</li>
    <li><i class="fas fa-tachometer-alt"></i>fa-tachometer-alt</li>
    <li><i class="fas fa-telescope"></i>fa-telescope</li>
    <li><i class="fas fa-temperature-high"></i>fa-temperature-high</li>
    <li><i class="fas fa-tint"></i>fa-tint</li>
    <li><i class="fas fa-torah"></i>fa-torah</li>
    <li><i class="fas fa-trophy"></i>fa-trophy</li>
    <li><i class="fas fa-truck-loading"></i>fa-truck-loading</li>
    <li><i class="fas fa-unicorn"></i>fa-unicorn</li>
    <li><i class="fas fa-user-ninja"></i>fa-user-ninja</li>
    <li><i class="fas fa-volleyball-ball"></i>fa-volleyball-ball</li>
    <li><i class="fas fa-walking"></i>fa-walking</li>
    <li><i class="fas fa-watermelon"></i>fa-watermelon</li>
    <li><i class="fas fa-whale"></i>fa-whale</li>
    <li><i class="fas fa-wind"></i>fa-wind</li>
    <li><i class="fas fa-kiwi-bird"></i>fa-kiwi-bird</li>
    <li><i class="fas fa-laptop"></i>fa-laptop</li>
    <li><i class="fas fa-lemon"></i>fa-lemon</li>
    <li><i class="fas fa-life-ring"></i>fa-life-ring</li>
    <li><i class="fas fa-magic"></i>fa-magic</li>
    <li><i class="fas fa-map-marked"></i>fa-map-marked</li>
    <li><i class="fas fa-mask"></i>fa-mask</li>
    <li><i class="fas fa-meteor"></i>fa-meteor</li>
    <li><i class="fas fa-mountain"></i>fa-mountain</li>
    <li><i class="fas fa-music"></i>fa-music</li>
    <li><i class="fas fa-narwhal"></i>fa-narwhal</li>
    <li><i class="fas fa-ninja"></i>fa-ninja</li>
    <li><i class="fas fa-otter"></i>fa-otter</li>
    <li><i class="fas fa-paper-plane"></i>fa-paper-plane</li>
    <li><i class="fas fa-paw"></i>fa-paw</li>
    <li><i class="fas fa-pepper-hot"></i>fa-pepper-hot</li>
    <li><i class="fas fa-people-carry"></i>fa-people-carry</li>
    <li><i class="fas fa-pizza-slice"></i>fa-pizza-slice</li>
    <li><i class="fas fa-praying-hands"></i>fa-praying-hands</li>
    <li><i class="fas fa-quidditch"></i>fa-quidditch</li>
    <li><i class="fas fa-rabbit"></i>fa-rabbit</li>
    <li><i class="fas fa-rainbow"></i>fa-rainbow</li>
    <li><i class="fas fa-ring"></i>fa-ring</li>
    <li><i class="fas fa-robot"></i>fa-robot</li>
    <li><i class="fas fa-rocket"></i>fa-rocket</li>
    <li><i class="fas fa-route"></i>fa-route</li>
    <li><i class="fas fa-ruler"></i>fa-ruler</li>
    <li><i class="fas fa-satellite"></i>fa-satellite</li>
    <li><i class="fas fa-seedling"></i>fa-seedling</li>
    <li><i class="fas fa-shield-alt"></i>fa-shield-alt</li>
    <li><i class="fas fa-snowflake"></i>fa-snowflake</li>
    <li><i class="fas fa-space-shuttle"></i>fa-space-shuttle</li>
    <li><i class="fas fa-spider"></i>fa-spider</li>
    <li><i class="fas fa-star"></i>fa-star</li>
    <li><i class="fas fa-sun"></i>fa-sun</li>
    <li><i class="fas fa-tachometer-alt"></i>fa-tachometer-alt</li>
    <li><i class="fas fa-telescope"></i>fa-telescope</li>
    <li><i class="fas fa-temperature-high"></i>fa-temperature-high</li>
    <li><i class="fas fa-tint"></i>fa-tint</li>
    <li><i class="fas fa-torah"></i>fa-torah</li>
    <li><i class="fas fa-trophy"></i>fa-trophy</li>
    <li><i class="fas fa-truck-loading"></i>fa-truck-loading</li>
    <li><i class="fas fa-unicorn"></i>fa-unicorn</li>
    <li><i class="fas fa-user-ninja"></i>fa-user-ninja</li>
    <li><i class="fas fa-volleyball-ball"></i>fa-volleyball-ball</li>
    <li><i class="fas fa-walking"></i>fa-walking</li>
    <li><i class="fas fa-watermelon"></i>fa-watermelon</li>
    <li><i class="fas fa-whale"></i>fa-whale</li>
    <li><i class="fas fa-wind"></i>fa-wind</li>
</ul>