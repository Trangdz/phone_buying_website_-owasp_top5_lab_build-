import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '0.0.0.0', // Cho phép truy cập từ các IP khác
    //     port: 5173,      // Có thể đổi nếu muốn
    //     strictPort: true,
    //     hmr: {
    //         host:'192.168.0.205', // IP LAN của bạn
    //     },
    // },
});
