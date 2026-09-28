import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix corrupted navigation and section start
# This part of the file is around line 107
corrupted_pattern = re.compile(r'</style></head>.*?<div class="secci-n-especial"', re.DOTALL)

clean_nav = '''</style></head><body class="body"><div id="luxy" class="main"><div class="c-nav"><div class="_w-nav"><div class="c-nav-content"><div class="c-nav-logo"><a href="/" aria-current="page" class="c-nav-logo-link w-inline-block w--current"><img src="./images/6368361aca5ec482e0c84cbf_bymike.png" loading="lazy" width="150" alt=""/></a></div><div class="c-nav-items"><a href="#servicios" class="link-block-10 w-inline-block"><h3 class="link-menu">servicios</h3></a><a href="#proyectos" class="link-block-10 w-inline-block"><h3 class="link-menu">PROYECTOS</h3></a><a href="#base-projects" class="link-block-10 menu w-inline-block"><h3 class="link-menu">Software propio</h3></a><div class="cloneable-area"><div class="c-nav-menu-btn"><div class="_w-nav-menu-btn"><div class="b-nav-menu-btn default"><div class="c-nav-menu-btn-icon"><div class="_w-nav-menu-btn-icon"><div class="nav-menu-btn-line long"></div><div style="width:70%" class="nav-menu-btn-line short"></div><div class="nav-menu-btn-line long"></div></div></div></div></div></div></div></div></div></div><div class="c-nav-menu-overlay"><div class="c-nav-menu-content"><nav class="c-col-menu-links"><div class="_w-col-menu-links"><div class="c-menu-item"><a href="#servicios" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1;"><div class="c-menu-item-number"><div class="menu-item-number">01</div></div><div class="c-menu-item-text"><div class="menu-item-text">Servicios</div></div></div></a></div><div class="c-menu-item"><a href="#proyectos" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1;"><div class="c-menu-item-number"><div class="menu-item-number">02</div></div><div class="c-menu-item-text"><div class="menu-item-text">Proyectos</div></div></div></a></div><div class="c-menu-item"><a href="#base-projects" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1;"><div class="c-menu-item-number"><div class="menu-item-number">03</div></div><div class="c-menu-item-text"><div class="menu-item-text">Software propio</div></div></div></a></div></div></nav></div></div></div><div class="secci-n-especial"'''

new_content = corrupted_pattern.sub(clean_nav, content)

# Also fix the weird padding text that appeared in line 111
new_content = re.sub(r'<!-- BASE BS 2.0 -->="padding-top: 40px; padding-bottom: 20px;">', '<!-- BASE BS 2.0 -->', new_content)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(new_content)

print("HTML cleanup completed.")
