import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Replace the specific CSS block for Navigation and Cards
# We target from the NAVBAR FIX comment to the end of the style tag
new_css = '''    /* NAVBAR FIX */
    .c-nav {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 9999 !important;
        background: rgba(10, 10, 10, 0.9) !important;
        backdrop-filter: blur(8px);
        height: 80px !important;
        display: block !important;
    }
    .c-nav-content {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        height: 100% !important;
        padding: 0 5% !important;
        max-width: 1400px !important;
        margin: 0 auto !important;
    }
    .c-nav-items {
        display: flex !important;
        gap: 30px !important;
        align-items: center !important;
    }
    .link-menu, .menu-item-text, .menu-item-number {
        color: white !important;
        font-size: 14px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        margin: 0 !important;
        text-decoration: none !important;
    }
    
    /* HAMBURGER BUTTON (Mobile only) */
    .c-nav-menu-btn {
        display: none !important;
    }

    @media screen and (max-width: 991px) {
        .c-nav-items {
            display: none !important;
        }
        .c-nav-menu-btn {
            display: flex !important;
            width: 40px !important;
            height: 40px !important;
            justify-content: center !important;
            align-items: center !important;
            cursor: pointer !important;
        }
        .b-nav-menu-btn.default {
            opacity: 1 !important;
        }
        .nav-menu-btn-line {
            background-color: white !important;
        }
    }

    /* CARD SCROLL FIX */
    .div-block-253 {
        height: auto !important;
        min-height: 280px;
        overflow: visible !important;
    }
    
    /* MOBILE OVERLAY FIX */
    .c-nav-menu-overlay {
        position: fixed !important;
        top: 0; left: 0; width: 100%; height: 100vh !important;
        background: black !important;
        z-index: 10000 !important;
        display: none;
        overflow-y: auto !important;
        padding-top: 100px !important;
    }
    .menu-item-text {
        font-size: 32px !important;
        font-weight: bold !important;
    }
    .menu-item-number {
        font-size: 16px !important;
        opacity: 0.7 !important;
        margin-right: 15px !important;
    }
    .c-menu-item {
        margin-bottom: 40px !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 10% !important;
    }
    .c-menu-item-link {
        text-decoration: none !important;
    }'''

# Replace from /* NAVBAR FIX */ to </style>
pattern = re.compile(r'/\* NAVBAR FIX \*/.*?</style>', re.DOTALL)
new_content = pattern.sub(new_css + '\n</style>', content)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(new_content)

print("Final CSS injection completed.")
