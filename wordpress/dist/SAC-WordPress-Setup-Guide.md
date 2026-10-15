# SAC WordPress वेबसाइट — इंस्टॉलेशन गाइड (आसान हिंदी में)

यह गाइड आपकी Next.js वेबसाइट के WordPress वर्ज़न को आपकी मौजूदा WordPress होस्टिंग पर लगाने के लिए है।
पहले **staging (टेस्ट साइट)** पर लगाएँ, सब जाँचें, फिर live साइट पर।

---

## आपको क्या मिला है

| फ़ाइल | क्या है |
|---|---|
| `SAC-WordPress-Theme.zip` | थीम (डिज़ाइन, पेज टेम्पलेट, CSS, JS, सभी इमेज) |
| `SAC-WordPress-Companion-Plugin.zip` | प्लगइन (Projects, Solutions, Leadership, Clients, Jobs, फ़ॉर्म, SEO, Importer) |
| `SAC-WordPress-cPanel-Package.zip` | cPanel File Manager से सीधे अपलोड करने वाला पैकेज (`wp-content/...` फ़ोल्डर स्ट्रक्चर में) |
| `SAC-WordPress-Setup-Guide.md` | यही गाइड |

**ज़रूरतें:** WordPress 6.5 या नया, PHP 7.4 या नया (PHP 8.1/8.2 सुझाया गया), MySQL 5.7+/MariaDB 10.3+।
Node.js, Next.js या Vercel की कोई ज़रूरत **नहीं** है।

---

## चरण 1 — पुरानी वेबसाइट का बैकअप लें (सबसे ज़रूरी)

1. cPanel में लॉगिन करें।
2. **Backup / Backup Wizard** खोलें → **Full Backup** डाउनलोड करें।
3. अलग से भी लें:
   - **phpMyAdmin** → अपना WordPress डेटाबेस चुनें → **Export** → *Quick* → *SQL* → **Go**। `.sql` फ़ाइल सेव करें।
   - **File Manager** → `public_html` (या जहाँ WordPress है) → `wp-content` फ़ोल्डर पर राइट-क्लिक → **Compress** → ZIP डाउनलोड करें।
4. वैकल्पिक: **UpdraftPlus** प्लगइन से भी पूरा बैकअप ले सकते हैं।

> बैकअप अपने कंप्यूटर पर रखें। इसके बिना आगे न बढ़ें।

---

## चरण 2 — Staging (टेस्ट) साइट बनाएँ

सबसे आसान तरीके:
- cPanel में **Softaculous / WordPress Toolkit** → अपनी साइट → **Staging / Clone** → `staging.आपकीसाइट.com` बनाएँ।
- या एक नया subdomain बनाकर उस पर नया WordPress इंस्टॉल करें।

आगे के सभी चरण पहले staging पर करें।

---

## चरण 3 — थीम इंस्टॉल करें

**तरीका A (Dashboard से):**
1. WordPress Admin → **Appearance → Themes → Add New → Upload Theme**।
2. `SAC-WordPress-Theme.zip` चुनें → **Install Now**।
3. **Activate** दबाएँ।

**तरीका B (cPanel से):** `SAC-WordPress-cPanel-Package.zip` को WordPress के root फ़ोल्डर (जहाँ `wp-config.php` है) में अपलोड करें → **Extract**। इससे थीम और प्लगइन दोनों सही जगह (`wp-content/themes/sac-theme` और `wp-content/plugins/sac-companion`) पहुँच जाएँगे। फिर Dashboard से थीम Activate करें।

> अगर ZIP अपलोड पर "file too large" आए, तो तरीका B इस्तेमाल करें।

---

## चरण 4 — प्लगइन सक्रिय करें

1. **Plugins → Add New → Upload Plugin** → `SAC-WordPress-Companion-Plugin.zip` → **Install Now** → **Activate**।
   (तरीका B इस्तेमाल किया है तो सीधे **Plugins** में जाकर *SAC Companion* को Activate करें।)
2. बाएँ मेनू में अब **SAC Website** नाम का नया मेनू दिखेगा।

---

## चरण 5 — कंटेंट और इमेज इम्पोर्ट करें

1. **SAC Website → Import & Setup** खोलें।
2. तीनों विकल्प टिक रहने दें:
   - "Home" को होमपेज बनाएँ
   - Header और Footer मेनू बनाएँ
   - Permalinks को "Post name" पर सेट करें
3. **Run import** दबाएँ (1–3 मिनट लग सकते हैं, पेज बंद न करें)।

इम्पोर्टर अपने-आप बनाता है:
- 7 पेज: Home, Solutions, Projects, About, Why SAC, Contact, Careers (सही टेम्पलेट के साथ)
- सभी प्रोजेक्ट, सॉल्यूशन, लीडरशिप, क्लाइंट, Why SAC पॉइंट्स और जॉब ओपनिंग
- सभी मूल इमेज Media Library में (मूल फ़ाइल नाम के साथ)
- Header मेनू, Footer Quick Links और Footer Services मेनू
- Site Settings में सारा टेक्स्ट (फ़ोन, ईमेल, पता, हीरो टेक्स्ट आदि)

**सुरक्षा:**
- आपके पुराने पेज, पोस्ट या मीडिया **डिलीट या बदले नहीं जाते**।
- अगर उसी नाम (slug) का पेज पहले से है (जैसे `/contact`), तो इम्पोर्टर नया डुप्लिकेट नहीं बनाता, बस उस पेज पर सही टेम्पलेट लगाता है। पुराना कंटेंट न बदले, इसके लिए staging पर पहले जाँच लें।
- इम्पोर्ट दोबारा चलाने पर डुप्लिकेट नहीं बनते।

---

## चरण 6 — होमपेज और मेनू जाँचें

- **Settings → Reading** → "A static page" → Homepage = **Home** होना चाहिए।
- **Settings → Permalinks** → **Post name** चुना होना चाहिए → **Save Changes** एक बार ज़रूर दबाएँ (इससे `/solutions/` जैसे URL ठीक चलते हैं)।
- **Appearance → Menus**:
  - *Header navigation* → मुख्य मेनू
  - *Footer — Quick Links* और *Footer — Services* → फ़ुटर के लिंक
  - यहाँ से लिंक जोड़/हटा/क्रम बदल सकते हैं।

---

## चरण 7 — कंटेंट कैसे बदलें (बिना कोड)

सब कुछ **SAC Website** मेनू में है:

| क्या बदलना है | कहाँ |
|---|---|
| होमपेज हीरो, बैनर, About/CTA टेक्स्ट, आँकड़े (stats) | **SAC Website → Site Settings** |
| फ़ोन, ईमेल, पता, WhatsApp, सोशल लिंक, फ़ुटर टेक्स्ट | **Site Settings** |
| सॉल्यूशन/सर्विस (टाइटल, विवरण, इमेज, पॉइंट्स) | **SAC Website → Solutions** |
| प्रोजेक्ट (इमेज, विवरण, लोकेशन) | **SAC Website → Projects** |
| प्रोजेक्ट फ़िल्टर कैटेगरी (Healthcare, Hospitality…) | **SAC Website → Industries** |
| क्लाइंट लोगो / मार्की (scroll होने वाले नाम) | **SAC Website → Clients (Marquee)** |
| लीडरशिप फ़ोटो, नाम, पद, प्रोफ़ाइल | **SAC Website → Leadership** |
| Why SAC पॉइंट्स | **SAC Website → Why SAC Pillars** |
| जॉब ओपनिंग (Careers) | **SAC Website → Job Openings** |
| हर पेज का SEO टाइटल और डिस्क्रिप्शन | पेज/आइटम एडिट करें → नीचे **SEO** बॉक्स |
| कॉन्टैक्ट/करियर फ़ॉर्म की एंट्री और रिज़्यूमे | **SAC Website → Form Submissions** |

**इमेज बदलना:** आइटम खोलें → *Featured Image* या इमेज फ़ील्ड में **Select image** → Media Library से चुनें या नई अपलोड करें → **Update**।

**क्रम (order) बदलना:** आइटम में *Page Attributes → Order* नंबर बदलें (छोटा नंबर पहले दिखता है)।

**Yoast / Rank Math:** अगर इनमें से कोई SEO प्लगइन चालू है, तो हमारा SEO बॉक्स अपने-आप पीछे हट जाता है ताकि डुप्लिकेट टैग न बनें।

---

## चरण 8 — फ़ॉर्म और ईमेल सेटअप

- फ़ॉर्म की ईमेल किस पते पर जाए: **Site Settings → Form notification email**।
- हर एंट्री **Form Submissions** में सेव होती है, ईमेल न भी पहुँचे तो डेटा सुरक्षित रहता है।
- रिज़्यूमे (PDF/DOC/DOCX, अधिकतम 5 MB) एक सुरक्षित फ़ोल्डर में रखे जाते हैं जो पब्लिक URL से नहीं खुलते; केवल Admin ही Submission पेज से डाउनलोड कर सकता है।
- ईमेल भरोसेमंद तरीके से पहुँचें, इसके लिए **WP Mail SMTP** प्लगइन लगाकर अपनी होस्टिंग का ईमेल/SMTP सेट करें (सुझाया गया)।
- स्पैम सुरक्षा पहले से है: छिपा honeypot फ़ील्ड, समय-जाँच, nonce और rate-limit।

---

## चरण 9 — Live करने से पहले जाँच सूची

Staging पर ये सब जाँचें (डेस्कटॉप **और** मोबाइल दोनों पर):

- [ ] सातों पेज खुलते हैं: `/`, `/solutions/`, `/projects/`, `/about/`, `/why-sac/`, `/contact/`, `/careers/`
- [ ] होमपेज हीरो का 3D एनीमेशन चलता है
- [ ] क्लाइंट मार्की scroll होता है और hover पर रुकता है
- [ ] Projects पेज पर Industry फ़िल्टर बटन काम करते हैं
- [ ] मोबाइल पर मेनू (☰) खुलता/बंद होता है
- [ ] सभी इमेज दिख रही हैं (कोई टूटी इमेज नहीं)
- [ ] Contact फ़ॉर्म भेजें → "sent" संदेश दिखे → ईमेल आए → Form Submissions में एंट्री दिखे
- [ ] Careers फ़ॉर्म में PDF रिज़्यूमे के साथ अप्लाई करें → एंट्री और रिज़्यूमे दिखे
- [ ] Header/Footer के सभी लिंक सही पेज पर जाते हैं
- [ ] Site Settings में कोई टेक्स्ट बदलें → साइट पर बदलाव दिखे
- [ ] कैशिंग प्लगइन (LiteSpeed, WP Rocket आदि) है तो बदलाव के बाद cache साफ़ करें

---

## चरण 10 — Live साइट पर लगाना

1. Live साइट का **ताज़ा बैकअप** फिर से लें (चरण 1)।
2. कम ट्रैफ़िक वाले समय पर चरण 3, 4, 5 और 6 दोहराएँ।
   - या Softaculous/WP Toolkit में **Push staging to live** इस्तेमाल करें।
3. Settings → Permalinks → **Save Changes** एक बार दबाएँ।
4. Cache साफ़ करें और चरण 9 की सूची live पर फिर से जाँचें।

---

## चरण 11 — Rollback (वापस पुरानी साइट पर जाना)

**तरीका 1 — केवल थीम बदलें (सबसे तेज़, 1 मिनट):**
Appearance → Themes → अपनी पुरानी थीम **Activate** करें। Settings → Reading में पुराना होमपेज चुनें। पुरानी साइट वापस आ जाएगी।

**तरीका 2 — इम्पोर्ट हटाएँ:**
SAC Website → Import & Setup → **Undo import** → कन्फ़र्म बॉक्स टिक करें → **Remove imported content**।
इससे केवल इम्पोर्टर द्वारा बनाए गए पेज, आइटम, इमेज, मेनू हटते हैं और पुराना होमपेज, permalink, मेनू सेटिंग वापस आ जाती है। आपके पुराने पेज और फ़ॉर्म एंट्री नहीं छुए जाते।
फिर पुरानी थीम Activate करें और SAC Companion प्लगइन Deactivate करें।

**तरीका 3 — पूरा बैकअप restore (आपात स्थिति):**
- cPanel → **Backup** → चरण 1 वाला बैकअप Restore करें, या
- phpMyAdmin → डेटाबेस → **Import** → अपनी `.sql` फ़ाइल; और File Manager से पुराना `wp-content` ZIP वापस Extract करें।

---

## समस्या और समाधान

| समस्या | समाधान |
|---|---|
| पेज पर "404 Not Found" | Settings → Permalinks → Post name → Save Changes |
| डिज़ाइन बिखरा हुआ दिखे | Cache/CDN साफ़ करें; थीम सही से Activate है जाँचें |
| इम्पोर्ट अधूरा रुक गया | फिर से **Run import** दबाएँ — डुप्लिकेट नहीं बनेंगे |
| फ़ॉर्म की ईमेल नहीं आ रही | WP Mail SMTP लगाएँ; Spam फ़ोल्डर देखें; एंट्री Form Submissions में मिलेगी |
| रिज़्यूमे अपलोड नहीं होता | होस्टिंग में `upload_max_filesize` और `post_max_size` कम से कम 8M करें (cPanel → MultiPHP INI Editor) |
| ZIP अपलोड "too large" | cPanel पैकेज (तरीका B) इस्तेमाल करें |

---

## डेवलपर नोट (वैकल्पिक)

CSS को दोबारा compile करने की ज़रूरत तभी है जब आप `sac-theme/src/theme.css` में Tailwind क्लास बदलें:
`node wordpress/build.mjs` (केवल डेवलपमेंट के लिए; live साइट पर Node की ज़रूरत नहीं)।
