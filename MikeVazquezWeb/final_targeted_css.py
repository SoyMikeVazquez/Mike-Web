import sys

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

targeted_css = """
    /* SURGICAL MOBILE CENTERING - FINAL REVISION */
    @media screen and (max-width: 991px) {
        /* Prevent ALL horizontal overflow */
        body, html, .main, * {
            max-width: 100vw !important;
            box-sizing: border-box !important;
        }

        /* Fix Hero Logo Overlap completely */
        .c-nav {
            position: relative !important;
            height: auto !important;
            padding: 10px 0 !important;
            background: #000 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .main { padding-top: 0 !important; }
        
        /* Force break words and center "Tu empresa necesita..." and "Brindo tres soluciones..." */
        .despre-text, .subtitlu-sectiune {
            text-align: center !important;
            margin: 0 auto 20px auto !important;
            padding: 0 15px !important;
            width: 100% !important;
            max-width: 100vw !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            display: block !important;
        }
        
        .despre-text.home1-copy, .despre-text.home {
            font-size: clamp(20px, 6vw, 28px) !important;
            line-height: 1.3 !important;
        }
        
        .div-block-229.home, .wrapper-3.home, .div-block-228, .div-block-227 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
            text-align: center !important;
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
        }

        /* Center Slider "01 / CREACION DE SOFTWARE" */
        .w-dyn-list, .w-dyn-items {
            margin: 0 !important;
            padding: 0 !important;
            width: 100vw !important;
        }
        .w-dyn-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            width: 100vw !important;
            margin: 0 !important;
            padding: 0 15px !important;
            box-sizing: border-box !important;
        }
        .div-block-225, .div-block-226 {
            text-align: center !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin: 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .heading { font-size: 24px !important; margin: 0 auto 5px auto !important; text-align: center !important; display: block !important;}
        .heading-6 { font-size: 22px !important; margin: 0 auto 5px auto !important; text-align: center !important; display: block !important;}
        .paragraph-5 { text-align: center !important; }

        /* Ensure "Qué esperarás si trabajas conmigo" numbers are perfectly centered */
        .div-block-19, .div-block-23, .nr-articol, .articol-3, .div-block-20 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
        }
        .text-block-10, .text-block-8, .text-block-9, .text-block-7 {
            text-align: center !important;
            display: block !important;
            margin: 5px auto !important;
            width: 100% !important;
        }

        /* Clean up overlaps */
        .div-block-231 {
            margin: 20px auto !important;
        }
    }
"""

end_marker = "</style>"
idx = content.rfind(end_marker)

# Replace any existing /* SURGICAL MOBILE CENTERING */ block
start_marker = "/* SURGICAL MOBILE CENTERING */"
start_idx = content.find(start_marker)

new_content = ""
if start_idx != -1:
     new_content = content[:start_idx] + targeted_css + "\n" + content[idx:]
else:
     new_content = content[:idx] + targeted_css + "\n" + content[idx:]

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(new_content)
print("Final CSS fixes applied securely.")
