import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# Remove the diff artifacts
content = content.replace('-<div class="secci-n-especial" style="padding-top: 40px; padding-bottom: 20px;">\n', '')
content = content.replace('+<div class="secci-n-especial" id="base-projects" style="padding-top: 40px; padding-bottom: 20px;">\n', '<div class="secci-n-especial" id="base-projects" style="padding-top: 40px; padding-bottom: 20px;">\n')

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Diff markers removed safely.")
