import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Remove luxy script and its initialization
content = re.sub(r'<script src="https://cjh\.sfo2\.cdn\.digitaloceanspaces\.com/Smooth-Scroll/luxy\.js"></script>', '', content)
content = re.sub(r'<script charset="utf-8">\s*luxy\.init\(\);\s*</script>', '', content)

# Remove the no-scroll class definition if it exists
content = re.sub(r'<style>\s*\.no-scroll\s*\{\s*overflow:\s*hidden;\s*\}\s*</style>', '', content)

# Remove the body class="no-scroll" toggle script since it relies on jQuery or might conflict
content = re.sub(r'<script>\s*\$\(\'\.c-nav-menu-btn-icon\'\)\.on\(\'click\', function\(\)\{\s*\$\(\'body\'\)\.toggleClass\(\'no-scroll\'\);\s*\}\);\s*</script>', '', content)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Luxy script and scroll lock dependencies removed.")
