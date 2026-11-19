from docx import Document

doc = Document(r'C:\Laragon\www\e-commerce\LAPRAK WEB.docx')
for i, p in enumerate(doc.paragraphs):
    text = p.text.strip()
    if text:
        print(f"P{i} [{p.style.name}]: {text}")
print('---TABLES---')
for t in range(len(doc.tables)):
    print('table', t)
print('---END---')
