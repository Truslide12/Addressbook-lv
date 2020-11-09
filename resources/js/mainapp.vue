<template>
    <div>
      <!--========== Logo ========-->
        <div class="_1side_menu" >
            <div class="_1side_menu_logo">
                <router-link to="/"><h3 style="text-align:center;">Address Book</h3></router-link>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <router-view></router-view>
            </div>
        </div>
    </div>
      <!--========== Logo ========-->
</template>
