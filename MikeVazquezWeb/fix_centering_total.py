import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

total_centering_css = """
        /* COMPLETE CENTERING OVERRIDES FOR MOBILE/TABLET */
        .subtitlu-sectiune, .subtitlu-sectiune.home1, .subtitlu-sectiune.home4, .subtitlu-sectiune.home1.white {
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto 20px auto !important;
            display: block !important;
        }

        .div-block-227, .div-block-228, .wrapper-3.home {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
        }

        .div-block-225 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
        }
        .div-block-225 .heading {
            line-height: 1.2 !important;
            text-align: center !important;
        }
        .div-block-225 .heading-6 {
            line-height: 1.2 !important;
            text-align: center !important;
        }

        .div-block-19, .div-block-20, .nr-articol, .div-block-23 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto 10px auto !important;
        }

        .text-block-7, .text-block-10, .text-block-9, .text-block-8, .text-block-12, .nav-social-address, .heading-5 {
            text-align: center !important;
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .c-nav-content {
            position: relative !important;
            justify-content: center !important;
        }
        .c-nav-logo, .c-nav-logo-link {
            display: flex !important;
            justify-content: center !important;
            margin: 0 auto !important;
        }
        .c-nav-menu-btn {
            position: absolute !important;
            right: 20px !important;
        }
"""
# We inject this right before the closing style tag (into the mobile media query, but making it globally applying to 991px max-width)
content = content.replace('/* BUTTONS & OTHERS */', total_centering_css + '\n        /* BUTTONS & OTHERS */')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Total centering rules applied.")
