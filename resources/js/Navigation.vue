<template>
    <section class="p-8">
        <nav class="flex justify-center menu">
            <ul class="flex-row flex justify-center gap-3 font-bold menu__list">
                <li v-for="item in navigation" :key="item.displayName" @mouseover="() => handleMouseOver(item)"
                    @mouseleave="handleMouseLeave" class="menu__item">
                    <a class="underline menu__link" :class="{ 'menu__link--disabled': item.disabled }"
                       :href="item.disabled ? null : item.url">{{ item.displayName }}</a>
                    <Transition name="fade">
                        <template v-if="showSubItems === item">
                            <ul class="item-with-subitems bg-slate-900 bg-opacity-25">
                                <li class="subitem" v-for="subItem in item.subItems" :key="subItem.displayName">
                                    <a :class="{ 'text-gray-800': subItem.disabled }"
                                       :href="subItem.disabled ? null : subItem.url">{{ subItem.displayName }}</a>
                                </li>
                            </ul>
                        </template>
                    </Transition>
                </li>
            </ul>
        </nav>
    </section>
</template>

<script setup>

import {ref} from 'vue';

const navigation = ref([
    {
        displayName: 'Home',
        url: '/newsite'
    },
    {
        displayName: 'Kategorien',
        url: '/categories',
        disabled: true,
    },
    {
        displayName: 'Artikelliste',
        url: '/articles'
    },
    {
        displayName: 'Verkaufen',
        url: '/newarticle'
    },
    {
        displayName: 'Unternehmen',
        subItems: [
            {
                displayName: 'Philosophie',
                url: '/philosophy',
                disabled: true,
            },
            {
                displayName: 'Karriere',
                url: '/career',
                disabled: true,
            }
        ]
    }
]);

const showSubItems = ref(null); // Track the currently hovered parent item

function handleMouseLeave() {
    showSubItems.value = null;
}

function handleMouseOver(item) {
    showSubItems.value = item;
}
</script>

<style lang="scss">
$menu-background-color: #18181b;
$menu-text-color: #ffffff;
$menu-hover-color: #ffffff;
$menu-disabled-color: #393939;
$gap: 1rem;
$padding: 1rem;
$border-radius: 0.5rem;
$transition-duration: 0.5s;
$white: white;

.menu {
    background-color: $menu-background-color;
    display: flex;
    justify-content: center;
}

.menu__list {
    display: flex;
    gap: 1rem;
    padding: 1rem;
}

.menu__item {
    position: relative;
    cursor: pointer;
}

.menu__link {
    color: $menu-text-color;
    text-decoration: none;

    &:hover {
        text-decoration: underline;
    }

    &--disabled {
        color: $menu-disabled-color;

        &:hover {
            color: $menu-disabled-color;
        }
    }
}

.menu__sublist {
    position: absolute;
    top: 100%;
    left: 0;
    display: none;
    padding: 1rem;
    background-color: $menu-background-color;
    border-radius: 0.5rem;
    z-index: 1;
}

.menu__subitem {
    display: block;
    padding: 0.5rem;
    color: white;

    &:hover {
        color: $menu-hover-color;
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.item-with-subitems {
    position: absolute;
    background-color: $menu-background-color;

}
</style>
