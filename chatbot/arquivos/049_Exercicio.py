from fastapi import FastAPI
import uvicorn
app = FastAPI()
@app.get("/")
def raiz():
    return {"mensagem": "API funcionando!"}
if __name__ == "__main__":
    uvicorn.run("049_Exercicio:app", host="0.0.0.0", port=8000, reload=True)