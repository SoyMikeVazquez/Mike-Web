import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix common missing accents in Spanish
replacements = {
    'últimos': 'últimos',
    'Últimos': 'Últimos',
    'creación': 'creación',
    'Creación': 'Creación',
    'automatización': 'automatización',
    'asesoría': 'asesoría',
    'tecnología': 'tecnología',
    'gestión': 'gestión',
    'estás': 'estás',
    'más': 'más',
    'día': 'día',
    'página': 'página',
    'atención': 'atención',
    'visión': 'visión',
    'comunicación': 'comunicación',
    'aplicación': 'aplicación',
    'aplicaciones': 'aplicaciones',
    'innovación': 'innovación',
    'satisfacción': 'satisfacción',
    'fácil': 'fácil',
    'móvil': 'móvil',
    'móviles': 'móviles',
    '¿Qué esperas?': '¿Qué esperas?',
    'estás a un clic': 'estás a un clic',
}

for old, new in replacements.items():
    content = content.replace(old, new)

# Ensure BASE names are consistent
content = content.replace('BASE bs 2.0', 'BASE BS 2.0')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Final accent and BASE corrections applied.")
