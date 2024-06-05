import antfu from '@antfu/eslint-config';
import tailwind from 'eslint-plugin-tailwindcss';

export default antfu({
    vue: true,
    typescript: true,
    stylistic: {
        indent: 4,
        quotes: 'single',
        semi: true,
    },
}, ...tailwind.configs['flat/recommended'], {
    settings: {
        tailwindcss: {
            config: 'tailwind.config.ts',
            cssFiles: [
                'resources/css/app.css',
            ],
        },
    },
});
