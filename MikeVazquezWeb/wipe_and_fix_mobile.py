import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# 1. Remove the custom blocks at the top (lines 5 to 92 approx)
# We find the first <style> tag content and the second </style>
# This is risky, let's use markers.
# The user added blocks often have comments.

# Let's just surgically remove the known injected strings.

# Remove first block
content = re.sub(r'/\* FORCE EVERYTHING VERTICAL ON TABLET/MOBILE \*/.*?\}\s*\}', '', content, flags=re.DOTALL)
# Remove second block
content = re.sub(r'@media screen and \(max-width: 991px\) \{\s*\.container-53 \{.*?\}\s*\}', '', content, flags=re.DOTALL)

# 2. Remove the blocks at the bottom
content = re.sub(r'/\* SAFE AND MINIMAL RESPONSIVE OPTIMIZATIONS FOR IPAD AND MOBILE \*/.*?\}\s*\}', '', content, flags=re.DOTALL)
content = re.sub(r'/\* SURGICAL MOBILE CENTERING - FINAL REVISION \*/.*?\}\s*\}', '', content, flags=re.DOTALL)

# 3. Inject ONE SINGLE CLEAN BLOCK at the end of head
# But we need to make sure we don't break the base styles.

clean_mobile_css = """
    /* FINAL STABLE MOBILE FIX */
    @media screen and (max-width: 991px) {
        /* Global Mobile Resets */
        body, html, .main {
            overflow-x: hidden !important;
            width: 100vw !important;
            position: relative !important;
        }
        * { box-sizing: border-box !important; }

        /* HERO SECTION FIXES (Fix overlap and "chueco") */
        .section-13.home {
            height: auto !important;
            min-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 80px 20px !important;
            position: relative !important;
        }
        .div-block-229.home {
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            transform: none !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            margin: 0 auto !important;
            z-index: 10 !important;
        }
        .despre-text.home1-copy {
            width: 100% !important;
            max-width: 100% !important;
            font-size: 28px !important;
            line-height: 1.2 !important;
            margin: 0 0 20px 0 !important;
            text-align: center !important;
        }
        .subtitlu-sectiune.home1.white {
            width: 100% !important;
            max-width: 100% !important;
            position: relative !important;
            text-align: center !important;
            margin: 20px 0 !important;
            font-size: 14px !important;
        }

        /* Nav Bar Fix */
        .c-nav {
            position: fixed !important; /* Keep it sticky but clean */
            top: 0; width: 100%; z-index: 1000;
            background: rgba(0,0,0,0.9) !important;
        }

        /* BRINDO TRES SOLUCIONES (Alineacion) */
        .demo_header, .wrapper-3.home {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            padding: 40px 20px !important;
            margin: 0 !important;
        }
        .despre-text.home {
            width: 100% !important;
            max-width: 100% !important;
            text-align: center !important;
            font-size: 24px !important;
        }
        .div-block-228 {
            width: 100% !important;
            max-width: 100% !important;
            text-align: center !important;
            margin-top: 15px !important;
            font-size: 16px !important;
        }

        /* Sliders / Cards Fixes */
        .w-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .w-col {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 20px !important;
        }
        
        /* Fix the "chueco" horizontal items */
        .div-block-225, .div-block-226 {
            width: 100% !important;
            text-align: center !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        
        /* Kill all negative margins */
        .div-block-205.home, .slider, .section__swipe {
            margin-top: 0 !important;
            margin-bottom: 20px !important;
        }
    }
"""

content = content.replace('</head>', '<style>' + clean_mobile_css + '</style></head>')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Wiped old mess and injected clean final fix.")
