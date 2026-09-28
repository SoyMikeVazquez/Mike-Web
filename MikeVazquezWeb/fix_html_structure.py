import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Fix the missing > and </a>
old_bad_code = '<img src="./images/6368361aca5ec482e0c84cbf_bymike.png" loading="lazy" width="150" alt=""/</div>'
new_good_code = '<img src="./images/6368361aca5ec482e0c84cbf_bymike.png" loading="lazy" width="150" alt=""/></a></div>'

content = content.replace(old_bad_code, new_good_code)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("HTML structural flaw fixed.")
