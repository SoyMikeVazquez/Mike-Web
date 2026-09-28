from bs4 import BeautifulSoup

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

soup = BeautifulSoup(content, 'html.parser')

c_nav = soup.find('div', class_='c-nav')
if c_nav:
    print("Children of c-nav:")
    for child in c_nav.children:
        if child.name:
            print(f" - <{child.name} class='{child.get('class', [])}'>")
    print(f"Is section-13 inside c-nav? {bool(c_nav.find('div', class_='section-13'))}")

body = soup.body
if body:
    print("\nChildren of body:")
    for child in body.children:
        if child.name:
            print(f" - <{child.name} class='{child.get('class', [])}'>")

