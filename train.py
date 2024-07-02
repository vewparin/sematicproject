# from flask import Flask, render_template, request
# from flask_cors import CORS
# import numpy as np
# import joblib
# import re
# from pythainlp import word_tokenize
# import emoji
# from sklearn.feature_extraction.text import TfidfVectorizer
# from sklearn.linear_model import LogisticRegression
# from sklearn.preprocessing import StandardScaler

# def replace_url(text):
#     URL_PATTERN = r"""(?i)\b((?:https?:(?:/{1,3}|[a-z0-9%])|[a-z0-9.\-]+[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)/)(?:[^\s()<>{}\[\]]+|\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\))+(?:\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’])|(?:(?<!@)[a-z0-9]+(?:[.\-][a-z0-9]+)*[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\b/?(?!@)))"""
#     return re.sub(URL_PATTERN, 'xxurl', text)

# def replace_rep(text):
#     def _replace_rep(m):
#         c, cc = m.groups()
#         return f'{c}xxrep'
#     re_rep = re.compile(r'(\S)(\1{2,})')
#     return re_rep.sub(_replace_rep, text)

# def ungroup_emoji(toks):
#     res = []
#     for tok in toks:
#         if emoji.emoji_count(tok) == len(tok):
#             for char in tok:
#                 res.append(char)
#         else:
#             res.append(tok)
#     return res

# def process_text(text):
#     # Pre rules
#     res = text.lower().strip()
#     res = replace_url(res)
#     res = replace_rep(res)

#     # Tokenize
#     res = [word for word in word_tokenize(res) if word and not re.search(pattern=r"\s+", string=word)]

#     # Post rules
#     res = ungroup_emoji(res)

#     return res

# app = Flask(__name__)
# CORS(app)  # เพิ่ม CORS support
# # Load the trained model
# loaded_model = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\trained_model.joblib')

# # Load preprocessing objects
# loaded_tfidf_transformer = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\tfidf_transformer.joblib')
# loaded_scaler_transformer = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\scaler_transformer.joblib')

# @app.route('/')


# def home():
#     return render_template('index.html')

# @app.route('/predict', methods=['POST'])
# # def predict():
# #     # Get the input text from the form
# #     new_text = request.form['new_text']

# #     # Process the new text
# #     processed_text = '|'.join(process_text(new_text))

# #     # Feature extraction using the loaded preprocessing objects
# #     text_features = loaded_tfidf_transformer.transform([new_text])
# #     num_features = loaded_scaler_transformer.transform([[len(processed_text.split('|')), len(set(processed_text.split('|')))]])
# #     new_text_features = np.concatenate([num_features, text_features.toarray()], axis=1)

# #     # Model prediction using the loaded model
# #     prediction = loaded_model.predict(new_text_features)

# #     return render_template('index.html', prediction=prediction[0], new_text=new_text)

# def predict():
#     data = request.json
#     if not data or 'text' not in data:
#         return jsonify({'error': 'Invalid input'}), 400
    
#     new_text = data['text']

#     # Process the new text
#     processed_text = '|'.join(process_text(new_text))

#     # Feature extraction using the loaded preprocessing objects
#     text_features = loaded_tfidf_transformer.transform([new_text])
#     num_features = loaded_scaler_transformer.transform([[len(processed_text.split('|')), len(set(processed_text.split('|')))]])
#     new_text_features = np.concatenate([num_features, text_features.toarray()], axis=1)

#     # Model prediction using the loaded model
#     prediction = loaded_model.predict(new_text_features)

#     return jsonify({'prediction': prediction[0].tolist(), 'text': new_text})


# def predict_category(new_text, tfidf_transformer, scaler_transformer, trained_model):
#     # Process the new text
#     processed_text = '|'.join(process_text(new_text))

#     # Feature extraction using the provided preprocessing objects
#     text_features = tfidf_transformer.transform([new_text])
#     num_features = scaler_transformer.transform([[len(processed_text.split('|')), len(set(processed_text.split('|')))]])
#     new_text_features = np.concatenate([num_features, text_features.toarray()], axis=1)

#     # Model prediction using the provided model
#     prediction = trained_model.predict(new_text_features)
#     return prediction[0]

# if __name__ == '__main__':
#     app.run(host='0.0.0.0', port=5000, debug=True)


from flask import Flask, render_template, request, jsonify
from flask_cors import CORS
import numpy as np
import joblib
import re
from pythainlp import word_tokenize
import emoji
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import LogisticRegression
from sklearn.preprocessing import StandardScaler

def replace_url(text):
    URL_PATTERN = r"""(?i)\b((?:https?:(?:/{1,3}|[a-z0-9%])|[a-z0-9.\-]+[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\b/?(?!@)))"""
    return re.sub(URL_PATTERN, 'xxurl', text)

def replace_rep(text):
    def _replace_rep(m):
        c, cc = m.groups()
        return f'{c}xxrep'
    re_rep = re.compile(r'(\S)(\1{2,})')
    return re_rep.sub(_replace_rep, text)

def ungroup_emoji(toks):
    res = []
    for tok in toks:
        if emoji.emoji_count(tok) == len(tok):
            for char in tok:
                res.append(char)
        else:
            res.append(tok)
    return res

def process_text(text):
    res = text.lower().strip()
    res = replace_url(res)
    res = replace_rep(res)

    res = [word for word in word_tokenize(res) if word and not re.search(r"\s+", word)]

    res = ungroup_emoji(res)

    return res

app = Flask(__name__)
CORS(app)  # เพิ่ม CORS support

# Load the trained model and transformers
loaded_model = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\trained_model.joblib')
loaded_tfidf_transformer = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\tfidf_transformer.joblib')
loaded_scaler_transformer = joblib.load(r'C:\xampp\htdocs\websematic\dumptfidf\scaler_transformer.joblib')

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    if not data or 'text' not in data:
        return jsonify({'error': 'Invalid input'}), 400
    
    new_text = data['text']

    processed_text = '|'.join(process_text(new_text))

    text_features = loaded_tfidf_transformer.transform([new_text])
    num_features = loaded_scaler_transformer.transform([[len(processed_text.split('|')), len(set(processed_text.split('|')))]])
    new_text_features = np.concatenate([num_features, text_features.toarray()], axis=1)

    prediction = loaded_model.predict(new_text_features)

    # แก้ไขการตอบกลับเพื่อไม่ใช้ tolist()
    return jsonify({'prediction': prediction[0], 'text': new_text})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
