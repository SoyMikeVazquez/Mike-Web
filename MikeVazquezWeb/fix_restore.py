import json

file_path = 'index.html'

with open(file_path, 'r', encoding='utf-8') as file:
    lines = file.readlines()

with open('recover_snippet.json', 'r', encoding='utf-8') as f:
    snippet = json.load(f)['LineContent']

# Find the line that starts with </style></head><body
for i, line in enumerate(lines):
    if line.startswith('</style></head><body'):
        lines[i] = snippet + '\n'
        break

with open(file_path, 'w', encoding='utf-8') as file:
    file.writelines(lines)

print("Restoration script executed.")
