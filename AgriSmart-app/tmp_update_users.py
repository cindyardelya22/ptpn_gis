import re

path = 'd:/ptpn/ptpn_gis/resources/views/livewire/users.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    c = f.read()

# Text colors
c = re.sub(r'\btext-white\b(?! dark:)', 'text-slate-800 dark:text-white', c)
c = re.sub(r'\btext-indigo-300/50\b(?! dark:)', 'text-slate-500 dark:text-indigo-300/50', c)
c = re.sub(r'\btext-indigo-400/50\b(?! dark:)', 'text-slate-500 dark:text-indigo-400/50', c)
c = re.sub(r'\btext-indigo-400/40\b(?! dark:)', 'text-slate-500 dark:text-indigo-400/40', c)
c = re.sub(r'\btext-indigo-300/40\b(?! dark:)', 'text-slate-500 dark:text-indigo-300/40', c)
c = re.sub(r'\btext-indigo-300/60\b(?! dark:)', 'text-slate-600 dark:text-indigo-300/60', c)
c = re.sub(r'\btext-indigo-300/20\b(?! dark:)', 'text-slate-400 dark:text-indigo-300/20', c)
c = re.sub(r'\btext-indigo-300\b(?!/| dark:)', 'text-slate-600 dark:text-indigo-300', c)

# Borders
c = re.sub(r'\bborder-white/5\b(?! dark:)', 'border-slate-200 dark:border-white/5', c)
c = re.sub(r'\bborder-white/10\b(?! dark:)', 'border-slate-200 dark:border-white/10', c)

# Root background
c = c.replace('class="min-h-screen relative users"', 'class="min-h-screen relative users bg-slate-100 dark:bg-slate-900"')

# Background inline styles
c = c.replace('style="background:rgba(255,255,255,.05)"', 'class="bg-white dark:bg-white/5"')
c = c.replace('style="background:rgba(15,23,42,1)"', 'class="bg-white dark:bg-slate-900"')

# Gradient backgrounds mapping to slate for dark mode cards
c = c.replace('style="background:linear-gradient(160deg,#1e1b4b,#0f172a);box-shadow:0 0 60px rgba(129,140,248,.2)"', 'class="bg-white dark:bg-slate-900 shadow-xl dark:shadow-[0_0_60px_rgba(129,140,248,.2)]"')
c = c.replace('style="background:linear-gradient(160deg,#1e1b4b,#0f172a);box-shadow:0 0 40px rgba(251,113,133,.15)"', 'class="bg-white dark:bg-slate-900 shadow-xl dark:shadow-[0_0_40px_rgba(251,113,133,.15)]"')

# Complex inline styles (stats cards)
c = re.sub(
    r'style="animation-delay:\s*(\d+)ms;\s*background:\s*rgba\(255,255,255,\.04\);\s*backdrop-filter:\s*blur\(12px\)"',
    r'style="animation-delay: \1ms;" class="bg-white dark:bg-white/5 backdrop-blur-md shadow-sm"',
    c
)

c = re.sub(
    r'style="animation-delay:\s*(\d+)ms;\s*background:rgba\(255,255,255,\.03\);\s*backdrop-filter:blur\(12px\)"',
    r'style="animation-delay: \1ms;" class="bg-white dark:bg-white/5 backdrop-blur-md shadow-sm"',
    c
)

with open(path, 'w', encoding='utf-8') as f:
    f.write(c)

print("Updated users.blade.php")
