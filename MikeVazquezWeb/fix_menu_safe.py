import re

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

new_nav = '''<nav class="c-col-menu-links"><div class="_w-col-menu-links"><div class="c-menu-item"><a href="#servicios" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1; transform: translate3d(0, 0, 0) scale3d(1, 1, 1);"><div class="c-menu-item-number"><div class="menu-item-number">01</div></div><div class="c-menu-item-text"><div class="menu-item-text">Servicios</div></div></div></a></div><div class="c-menu-item"><a href="#proyectos" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1; transform: translate3d(0, 0, 0) scale3d(1, 1, 1);"><div class="c-menu-item-number"><div class="menu-item-number">02</div></div><div class="c-menu-item-text"><div class="menu-item-text">Proyectos</div></div></div></a></div><div class="c-menu-item"><a href="#base-projects" class="c-menu-item-link _2 w-inline-block"><div class="_w-menu-item-link" style="opacity: 1; transform: translate3d(0, 0, 0) scale3d(1, 1, 1);"><div class="c-menu-item-number"><div class="menu-item-number">03</div></div><div class="c-menu-item-text"><div class="menu-item-text">Software propio</div></div></div></a></div></div></nav>'''

pattern = re.compile(r'<nav class="c-col-menu-links">.*?</nav>', re.DOTALL)
new_content = pattern.sub(new_nav, content)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(new_content)

print("Safe menu replacement done.")
