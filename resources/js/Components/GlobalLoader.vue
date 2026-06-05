<template>
    <Transition name="loader">
        <div v-if="isLoading"
            class="fixed inset-0 z-99999 bg-white/80 backdrop-blur-md flex flex-col items-center justify-center">
            <!-- Loader -->
            <div class="relative flex items-center justify-center">

                <!-- Halo -->
                <div class="loader-glow"></div>

                <!-- Anneau externe -->
                <div class="w-32 h-32 rounded-full border-[3px] border-[#E8F3EE]"></div>

                <!-- Anneau animé -->
                <div class="loader-ring"></div>

                <!-- Logo -->
                <div
                    class="absolute w-20 h-20 rounded-3xl bg-brand-primary shadow-2xl flex items-center justify-center">
                    <i class="fas fa-leaf text-white text-3xl leaf-float"></i>
                </div>
            </div>

            <!-- Branding -->
            <div class="mt-8 text-center">
                <h3 class="text-brand-dark font-bold text-xl tracking-wide">
                    AgriLink
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Juste un instant...
                </p>

                <!-- Dots -->
                <div class="flex justify-center gap-2 mt-5">
                    <span class="dot"></span>
                    <span class="dot delay-1"></span>
                    <span class="dot delay-2"></span>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { isLoading } from "../Composables/useGlobalLoader";
</script>

<style scoped>
/* ========================================
   TRANSITION
======================================== */

.loader-enter-active,
.loader-leave-active {
    transition: all .35s ease;
}

.loader-enter-from,
.loader-leave-to {
    opacity: 0;
}

.loader-enter-from>*,
.loader-leave-to>* {
    transform: scale(.96);
}

/* ========================================
   RING
======================================== */

.loader-ring {
    position: absolute;
    width: 128px;
    height: 128px;
    border-radius: 9999px;
    border: 3px solid transparent;
    border-top-color: #2D6A4F;
    border-right-color: #40916C;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ========================================
   GLOW
======================================== */

.loader-glow {
    position: absolute;
    width: 90px;
    height: 90px;
    background: rgba(45, 106, 79, .18);
    border-radius: 9999px;
    filter: blur(22px);
    animation: pulseGlow 2.5s ease-in-out infinite;
}

@keyframes pulseGlow {

    0%,
    100% {
        transform: scale(1);
        opacity: .5;
    }

    50% {
        transform: scale(1.2);
        opacity: 1;
    }
}

/* ========================================
   LEAF
======================================== */

.leaf-float {
    animation: leafFloat 2s ease-in-out infinite;
}

@keyframes leafFloat {

    0%,
    100% {
        transform: translateY(-2px);
    }

    50% {
        transform: translateY(4px);
    }
}

/* ========================================
   DOTS
======================================== */

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2D6A4F;
    animation: dotBounce 1.4s infinite ease-in-out;
}

.delay-1 {
    animation-delay: .2s;
}

.delay-2 {
    animation-delay: .4s;
}

@keyframes dotBounce {

    0%,
    80%,
    100% {
        transform: scale(.5);
        opacity: .4;
    }

    40% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>