import re

path = 'd:/ptpn/ptpn_gis/resources/views/livewire/users.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    c = f.read()

# Merge multiple class attributes
# We'll run this a few times to catch all
for _ in range(5):
    c = re.sub(r'class="([^"]*)"\s+class="([^"]*)"', r'class="\1 \2"', c)

# Some cards use background:rgba(255,255,255,.04); and backdrop-filter:blur(12px) 
# Wait, they were already replaced by the previous script. Let's make sure there are no other duplicate classes.
with open(path, 'w', encoding='utf-8') as f:
    f.write(c)

print('Cleaned duplicate classes.')
