import os
import shutil

# Root directory for dataset creation
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
DATASET_DIR = os.path.join(BASE_DIR, 'dataset_nominal')

NOMINALS = ['100.000', '50.000', '20.000', '10.000', '5.000', '2.000', '1.000']

def create_folders():
    print("Membuat struktur folder dataset untuk Teachable Machine...")
    for nominal in NOMINALS:
        folder_path = os.path.join(DATASET_DIR, nominal)
        os.makedirs(folder_path, exist_ok=True)
        print(f"  [+] Folder dibuat: dataset_nominal/{nominal}")
    
    print("\n[SELESAI] Folder dataset siap!")
    print("Silakan masukkan foto uang Rupiah sesuai nominal ke dalam folder masing-masing di 'dataset_nominal/'.")
    print("Setelah itu, Anda tinggal drag & drop seluruh isi folder ke Google Teachable Machine!")

if __name__ == '__main__':
    create_folders()
