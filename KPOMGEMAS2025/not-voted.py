import csv

def read_all_voters(file_path, start_row=1):
    all_voters = []
    with open(file_path, mode='r', newline='', encoding='utf-8') as file:
        reader = csv.DictReader(file)
        for i, row in enumerate(reader, start=1):  # start=1 biar baris pertama = 1
            if i < start_row:
                continue  # skip dulu
            all_voters.append(row['nama'].strip())
    return all_voters

def read_voted_voters(file_path, start_row=1):
    voted_voters = []
    with open(file_path, mode='r', newline='', encoding='utf-8') as file:
        reader = csv.DictReader(file)
        for i, row in enumerate(reader, start=1):
            if i < start_row:
                continue
            voted_voters.append(row['nama'].strip())
    return voted_voters

def calculate_not_voted(all_voters_file, voted_file, start_row_all=1, start_row_voted=1):
    all_voters = read_all_voters(all_voters_file, start_row_all)
    voted_voters = read_voted_voters(voted_file, start_row_voted)
    
    not_voted = [name for name in all_voters if name not in voted_voters]
    
    total_voters = len(all_voters)
    total_voted = len(voted_voters)
    total_not_voted = len(not_voted)
    percentage_voted = (total_voted / total_voters) * 100 if total_voters > 0 else 0
    
    print("List nama-nama yang belum memilih:")
    for name in not_voted: 
        print(f"- {name}")
    print(f"\nYang sudah memilih: {total_voted}/{total_voters} [{percentage_voted:.2f}%]")
    print(f'Yang belum memilih: {total_not_voted}')
    print("\n")


# contoh panggil
all_voters_file = 'data.csv'
voted_file = 'csv/voted.csv'

# misalnya ambil data mulai dari baris ke-5
calculate_not_voted(all_voters_file, voted_file, start_row_all=357, start_row_voted=1)
