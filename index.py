import tabula

tabula.convert_into('./data/mpesa.pdf', "./data/mpesa.csv", 
                    output_format="csv", pages = 'all', password='password')

