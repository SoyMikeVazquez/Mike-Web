import sys

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

targeted_css = """
    /* SURGICAL MOBILE CENTERING */
    @media screen and (max-width: 991px) {
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
        .main { padding-top: 20px !important; }
        
        /* Center "Tu empresa necesita..." and "Brindo tres soluciones..." */
        .despre-text.home1-copy, .despre-text.home, .subtitlu-sectiune.home1.white {
            text-align: center !important;
            margin: 0 auto 20px auto !important;
            padding: 0 55px !important;
            width: 100% !important;
            max-width: 100% !important;
            white-space: normal !important;
            display: block !important;
        }
        .div-block-229.home, .wrapper-3.home {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            text-align: center !important;
            left: 0 !important;
            transform: none !important;
        }
        .div-block-228 { 
            text-align: center !important; 
            margin: 0 auto !important; 
        }

        /* Center Slider "01 / CREACION DE SOFTWARE" without pushing right */
        .w-dyn-list, .w-dyn-items {
            margin: 0 !important;
            padding: 0 !important;
        }
        .w-dyn-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            width: 100vw !important;  /* Fills screen */
            margin: 0 !important;
            padding: 0 15px !important;
            box-sizing: border-box !important;
        }
        .div-block-225, .div-block-226 {
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .heading, .heading-6 { 
            text-align: center !important; 
            margin: 0 auto 5px auto !important; 
            display: block !important;
        }

        /* Center "EXPERIENCIA" and disconnect it from "MIKE" graphic */
        .wrapper-3.home1 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }
        .div-block-227 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
            margin: 0 auto !important;
        }
        .subtitlu-sectiune.home1, .text-block-26 {
            text-align: center !important;
            margin: 0 auto 15px auto !important;
            width: 100% !important;
            display: block !important;
        }
        /* Push the MIKE graphic below the text rather than side-by-side */
        .div-block-231 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            margin: 20px auto !important;
            width: 100% !important;
        }
        
        /* Ensure "Qué esperarás si trabajas conmigo" blocks are stacked and centered */
        .div-block-19, .div-block-23, .nr-articol, .articol-3 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            justify-content: center !important;
            width: 100% !important;
            margin: 0 auto 10px auto !important;
        }
        .text-block-10, .text-block-8, .text-block-9, .text-block-7 {
            text-align: center !important;
            margin: 0 auto !important;
        }
    }
"""

end_marker = "</style>"
idx = content.rfind(end_marker)
if idx != -1:
    new_content = content[:idx] + targeted_css + "\n" + content[idx:]
    with open(file_path, 'w', encoding='utf-8') as file:
        file.write(new_content)
    print("Targeted CSS applied seamlessly.")
else:
    print("Error.")
