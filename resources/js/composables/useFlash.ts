// composables/useFlash.ts
import { router } from '@inertiajs/vue3';
import { onUnmounted } from 'vue';
import { toast } from 'vue-sonner';

export function useFlash() {
    const removeListener = router.on('flash', (event) => {
        const flash = event.detail.flash as any;
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    });

    onUnmounted(() => removeListener());
}
