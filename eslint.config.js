// ===========================================
// ESLint Configuration (Flat Config)
// https://eslint.org/docs/latest/use/configure/
// ===========================================

import js from '@eslint/js';
import globals from 'globals';

export default [
    // Base recommended config
    js.configs.recommended,

    // Global ignores
    {
        ignores: [
            'node_modules/**',
            'vendor/**',
            'public/**',
            'storage/**',
            'bootstrap/cache/**',
            '*.min.js',
        ],
    },

    // Main configuration
    {
        files: ['resources/js/**/*.js'],

        languageOptions: {
            ecmaVersion: 2022,
            sourceType: 'module',
            globals: {
                ...globals.browser,
                ...globals.es2021,
                // Laravel/Vite globals
                axios: 'readonly',
                _: 'readonly',
                $: 'readonly',
                jQuery: 'readonly',
                bootstrap: 'readonly',
                moment: 'readonly',
                Swal: 'readonly',
                NProgress: 'readonly',
                Prism: 'readonly',
                SimpleMDE: 'readonly',
                Config: 'readonly',
                AppConfig: 'readonly',
                // Vite
                'import.meta': 'readonly',
            },
        },

        rules: {
            // ===========================================
            // Possible Errors
            // ===========================================
            'no-console': ['warn', { allow: ['warn', 'error'] }],
            'no-debugger': 'warn',
            'no-duplicate-imports': 'error',
            'no-template-curly-in-string': 'error',
            'no-unreachable-loop': 'error',

            // ===========================================
            // Best Practices
            // ===========================================
            'curly': ['error', 'all'],
            'default-case-last': 'error',
            'default-param-last': 'error',
            'dot-notation': 'error',
            'eqeqeq': ['error', 'always', { null: 'ignore' }],
            'grouped-accessor-pairs': 'error',
            'no-alert': 'warn',
            'no-caller': 'error',
            'no-constructor-return': 'error',
            'no-else-return': 'error',
            'no-empty-function': 'warn',
            'no-eval': 'error',
            'no-extend-native': 'error',
            'no-extra-bind': 'error',
            'no-floating-decimal': 'error',
            'no-implicit-coercion': 'error',
            'no-implied-eval': 'error',
            'no-invalid-this': 'error',
            'no-labels': 'error',
            'no-lone-blocks': 'error',
            'no-loop-func': 'error',
            'no-multi-spaces': 'error',
            'no-multi-str': 'error',
            'no-new': 'error',
            'no-new-func': 'error',
            'no-new-wrappers': 'error',
            'no-param-reassign': ['error', { props: false }],
            'no-return-assign': 'error',
            'no-return-await': 'error',
            'no-script-url': 'error',
            'no-self-compare': 'error',
            'no-sequences': 'error',
            'no-throw-literal': 'error',
            'no-unmodified-loop-condition': 'error',
            'no-unused-expressions': ['error', { allowShortCircuit: true, allowTernary: true }],
            'no-useless-call': 'error',
            'no-useless-concat': 'error',
            'no-useless-return': 'error',
            'prefer-promise-reject-errors': 'error',
            'prefer-regex-literals': 'error',
            'radix': 'error',
            'require-await': 'error',
            'yoda': 'error',

            // ===========================================
            // Variables
            // ===========================================
            'no-shadow': 'error',
            'no-undef-init': 'error',
            'no-unused-vars': ['error', {
                argsIgnorePattern: '^_',
                varsIgnorePattern: '^_',
            }],
            'no-use-before-define': ['error', { functions: false }],

            // ===========================================
            // Stylistic Issues
            // ===========================================
            'array-bracket-spacing': ['error', 'never'],
            'block-spacing': 'error',
            'brace-style': ['error', '1tbs', { allowSingleLine: true }],
            'camelcase': ['error', { properties: 'never' }],
            'comma-dangle': ['error', 'always-multiline'],
            'comma-spacing': 'error',
            'comma-style': 'error',
            'computed-property-spacing': 'error',
            'eol-last': 'error',
            'func-call-spacing': 'error',
            'indent': ['error', 4, { SwitchCase: 1 }],
            'key-spacing': 'error',
            'keyword-spacing': 'error',
            'linebreak-style': ['error', 'unix'],
            'max-len': ['warn', {
                code: 120,
                ignoreUrls: true,
                ignoreStrings: true,
                ignoreTemplateLiterals: true,
                ignoreRegExpLiterals: true,
            }],
            'new-parens': 'error',
            'no-lonely-if': 'error',
            'no-mixed-operators': 'error',
            'no-multi-assign': 'error',
            'no-multiple-empty-lines': ['error', { max: 1, maxEOF: 0 }],
            'no-nested-ternary': 'error',
            'no-new-object': 'error',
            'no-tabs': 'error',
            'no-trailing-spaces': 'error',
            'no-unneeded-ternary': 'error',
            'no-whitespace-before-property': 'error',
            'object-curly-spacing': ['error', 'always'],
            'one-var': ['error', 'never'],
            'operator-linebreak': ['error', 'before'],
            'padded-blocks': ['error', 'never'],
            'prefer-object-spread': 'error',
            'quote-props': ['error', 'as-needed'],
            'quotes': ['error', 'single', { avoidEscape: true }],
            'semi': ['error', 'always'],
            'semi-spacing': 'error',
            'space-before-blocks': 'error',
            'space-before-function-paren': ['error', {
                anonymous: 'always',
                named: 'never',
                asyncArrow: 'always',
            }],
            'space-in-parens': 'error',
            'space-infix-ops': 'error',
            'space-unary-ops': 'error',
            'spaced-comment': ['error', 'always'],
            'switch-colon-spacing': 'error',
            'template-tag-spacing': 'error',

            // ===========================================
            // ECMAScript 6
            // ===========================================
            'arrow-body-style': ['error', 'as-needed'],
            'arrow-parens': ['error', 'as-needed'],
            'arrow-spacing': 'error',
            'generator-star-spacing': ['error', { before: false, after: true }],
            'no-confusing-arrow': 'error',
            'no-duplicate-imports': 'error',
            'no-useless-computed-key': 'error',
            'no-useless-constructor': 'error',
            'no-useless-rename': 'error',
            'no-var': 'error',
            'object-shorthand': 'error',
            'prefer-arrow-callback': 'error',
            'prefer-const': 'error',
            'prefer-destructuring': ['error', {
                array: false,
                object: true,
            }],
            'prefer-numeric-literals': 'error',
            'prefer-rest-params': 'error',
            'prefer-spread': 'error',
            'prefer-template': 'error',
            'rest-spread-spacing': 'error',
            'symbol-description': 'error',
            'template-curly-spacing': 'error',
            'yield-star-spacing': 'error',
        },
    },
];
